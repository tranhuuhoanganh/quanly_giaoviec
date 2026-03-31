/**
 * Deadline Countdown Handler
 * Xử lý countdown realtime cho deadline và gọi API khi về 0
 */

(function($) {
    'use strict';
    
    var socket = io("https://chat.socdo.vn");

    // Object quản lý các countdown đang chạy
    var DeadlineCountdown = {
        timers: {},
        
        /**
         * Khởi tạo countdown cho một element
         */
        init: function(element) {
            var $element = $(element);
            // Đọc từ data attribute hoặc data() method (ưu tiên attr vì chính xác hơn)
            var deadlineTimestamp = parseInt($element.attr('data-deadline') || $element.data('deadline')) || 0;
            var taskId = $element.attr('data-id') || $element.data('id');
            var taskType = $element.attr('data-type') || $element.data('type');
            
            // Debug log
            console.log('DeadlineCountdown.init:', {
                deadlineTimestamp: deadlineTimestamp,
                taskId: taskId,
                taskType: taskType,
                element: $element[0]
            });
            
            if (!deadlineTimestamp || deadlineTimestamp <= 0) {
                $element.html('<span class="deadline_no_date">Không có deadline</span>');
                console.warn('DeadlineCountdown: No valid deadline timestamp');
                return;
            }
            
            if (!taskId || !taskType) {
                console.warn('DeadlineCountdown: Missing taskId or taskType', {taskId: taskId, taskType: taskType});
                return;
            }
            
            // Lưu thông tin vào element
            $element.data('taskId', taskId);
            $element.data('taskType', taskType);
            $element.data('deadlineTimestamp', deadlineTimestamp);
            
            // Bắt đầu countdown
            this.startCountdown($element);
        },
        
        /**
         * Bắt đầu countdown
         */
        startCountdown: function($element) {
            var self = this;
            var deadlineTimestamp = $element.data('deadlineTimestamp');
            var taskId = $element.data('taskId');
            var taskType = $element.data('taskType');
            var timerId = taskType + '_' + taskId;
            
            // Xóa timer cũ nếu có
            if (this.timers[timerId]) {
                clearInterval(this.timers[timerId]);
            }
            
            // Cập nhật ngay lập tức
            this.updateCountdown($element);
            
            // Cập nhật mỗi giây
            this.timers[timerId] = setInterval(function() {
                self.updateCountdown($element);
            }, 1000);
        },
        
        /**
         * Cập nhật hiển thị countdown
         */
        updateCountdown: function($element) {
            var deadlineTimestamp = $element.data('deadlineTimestamp');
            var taskId = $element.data('taskId');
            var taskType = $element.data('taskType');
            var currentTime = Math.floor(Date.now() / 1000);
            var remaining = deadlineTimestamp - currentTime;
            
            if (remaining <= 0) {
                // Đã quá hạn
                $element.html('<span class="deadline_overdue_text"><i class="fa fa-exclamation-triangle"></i> Đã quá hạn</span>');
                
                // Gọi API để xác nhận trạng thái và cập nhật trang_thai
                this.checkDeadlineStatus(taskId, taskType, $element);
                
                // Dừng timer
                var timerId = taskType + '_' + taskId;
                if (this.timers[timerId]) {
                    clearInterval(this.timers[timerId]);
                    delete this.timers[timerId];
                }
            } else {
                // Còn thời gian
                var days = Math.floor(remaining / 86400);
                var hours = Math.floor((remaining % 86400) / 3600);
                var minutes = Math.floor((remaining % 3600) / 60);
                var seconds = remaining % 60;
                
                var countdownText = '';
                
                if (days > 0) {
                    countdownText = days + ' ngày ' + hours + ' giờ';
                } else if (hours > 0) {
                    countdownText = hours + ' giờ ' + minutes + ' phút';
                } else if (minutes > 0) {
                    countdownText = minutes + ' phút ' + seconds + ' giây';
                } else {
                    countdownText = seconds + ' giây';
                }
                
                // Thêm class warning nếu còn < 10 phút
                var className = 'deadline_countdown_text';
                if (remaining < 600) { // 10 phút
                    className += ' deadline_warning_text';
                } else if (remaining < 3600) { // 1 giờ
                    className += ' deadline_soon_text';
                }
                
                $element.html('<span class="' + className + '"><i class="fa fa-clock-o"></i> Còn ' + countdownText + '</span>');
            }
        },
        
        /**
         * Gọi API để check deadline status
         */
        checkDeadlineStatus: function(taskId, taskType, $element) {
            $.ajax({
                url: '/members/process.php',
                type: 'POST',
                data: {
                    action: 'check_deadline',
                    id: taskId,
                    type: taskType
                },
                dataType: 'json',
                success: function(response) {
                    if (response.ok) {
                        // Cập nhật lại deadline timestamp nếu server trả về
                        if (response.deadline_timestamp) {
                            $element.data('deadlineTimestamp', response.deadline_timestamp);
                        }
                        
                        if (response.trang_thai_list_item) {
                            $('#status_trang_thai_item').html(response.trang_thai_list_item);
                        }
                        if (response.trang_thai_list_item) {
                            $('#status_trang_thai_du_an').html(response.trang_thai_du_an);
                        }
                        // Nếu đã quá hạn, hiển thị thông báo
                        if (response.is_overdue) {
                            // Có thể trigger event để các component khác xử lý
                            $(document).trigger('deadline:overdue', {
                                taskId: taskId,
                                taskType: taskType,
                                response: response
                            });
                            
                            // Hiển thị thông báo nếu cần
                            if (typeof showNotification === 'function') {
                                showNotification('Công việc đã quá hạn deadline', 'warning');
                            }
                        }
                    }
                },
                error: function() {
                    console.error('Lỗi khi check deadline status');
                }
            });
        },
        
        /**
         * Dừng countdown cho một task
         */
        stop: function(taskId, taskType) {
            var timerId = taskType + '_' + taskId;
            if (this.timers[timerId]) {
                clearInterval(this.timers[timerId]);
                delete this.timers[timerId];
            }
        },
        
        /**
         * Dừng tất cả countdown
         */
        stopAll: function() {
            for (var timerId in this.timers) {
                clearInterval(this.timers[timerId]);
            }
            this.timers = {};
        }
    };
    
    // Khởi tạo khi DOM ready
    $(document).ready(function() {
        // Khởi tạo các countdown có sẵn
        $('.deadline_countdown').each(function() {
            DeadlineCountdown.init(this);
        });
    });
    
    // Hàm helper để khởi tạo countdown cho element mới (gọi từ bên ngoài)
    window.initDeadlineCountdown = function(container) {

        if (typeof DeadlineCountdown !== 'undefined') {
    
            // 🔥 QUAN TRỌNG: clear toàn bộ timer cũ
            DeadlineCountdown.stopAll();
    
            var $container = container ? $(container) : $(document);
    
            $container.find('.deadline_countdown').each(function() {
                DeadlineCountdown.init(this);
            });
        }
    };
    
    // Expose global
    window.DeadlineCountdown = DeadlineCountdown;
    
})(jQuery);
