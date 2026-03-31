<div class="box_pop_add_user">
  <div class="box_pop_add_user_dialog">
    <div class="box_pop_add_user_content">

      <div class="box_pop_add_user_header">
        <h5 class="box_pop_add_user_title">Thêm nhân sự</h5>
        <button type="button" class="box_pop_add_user_close" aria-label="Đóng">
          <i class="fa fa-times"></i>
        </button>
      </div>

      <div class="box_pop_add_user_body">
        <form class="box_pop_add_user_form" autocomplete="off">

          <div class="box_pop_add_user_grid">
            <div class="box_pop_add_user_main">

              <div class="box_pop_add_user_fields">

                <div class="field field_half">
                  <label class="field_label">Tên đăng nhập (*)</label>
                  <input class="field_input" name="username" type="text"
                    placeholder="Viết liền không dấu, không chứa ký tự đặc biệt">
                </div>

                <div class="field field_half">
                  <label class="field_label">Mật khẩu (*)</label>
                  <input class="field_input" name="password" type="password">
                </div>

                <div class="field field_half">
                  <label class="field_label">Họ tên</label>
                  <input class="field_input" name="name" type="text">
                </div>

                <div class="field field_half">
                  <label class="field_label">Email</label>
                  <input class="field_input" name="email" type="email">
                </div>

                <div class="field field_half">
                  <label class="field_label">Số điện thoại</label>
                  <input class="field_input" name="mobile" type="text">
                </div>

                <div class="field field_half">
                  <label class="field_label">Địa chỉ</label>
                  <input class="field_input" name="address" type="text">
                </div>

                <div class="field field_half">
                  <label class="field_label">Số hợp đồng lao động</label>
                  <input class="field_input" id="input_so_hopdong" name="so_hopdong" type="file">
                </div>

                <div class="field field_half">
                  <label class="field_label">Thời hạn hợp đồng</label>
                  <input class="field_input" name="time_hopdong" type="date">
                </div>

                <div class="field field_half">
                  <label class="field_label">Số CCCD</label>
                  <input class="field_input" name="so_cccd" type="text">
                </div>

                <div class="field field_half">
                  <label class="field_label">Ngày cấp</label>
                  <input class="field_input" name="ngay_cap_cccd" type="date">
                </div>

                <div class="field field_full">
                  <label class="field_label">Loại hình hợp đồng</label>
                  <div class="radio-group">
                    <label class="radio">
                      <input type="radio" name="loai_hopdong" value="thuctap">
                      <span>Thực tập</span>
                    </label>
                    <label class="radio">
                      <input type="radio" name="loai_hopdong" value="parttime">
                      <span>Part-time</span>
                    </label>
                    <label class="radio">
                      <input type="radio" name="loai_hopdong" value="thuviec">
                      <span>Thử việc</span>
                    </label>
                    <label class="radio">
                      <input type="radio" name="loai_hopdong" value="chinhthuc">
                      <span>Chính thức</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <aside class="box_pop_add_user_aside">
              <div class="avatar-placeholder" role="img" aria-label="Avatar người dùng">
                <img id="preview_avatar" src="" alt="Avatar" style="display:none;">
                <svg id="avatar_icon" width="48" height="48" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM2 14s1-4 6-4 6 4 6 4-1 0-6 0-6 0-6 0z" />
                </svg>
              </div>

              <button type="button" class="btn-choose-photo" onclick="document.getElementById('input_avatar').click();">
                Chọn ảnh
              </button>

              <input type="file" id="input_avatar" name="avatar" accept="image/*" style="display:none;">
            </aside>

          </div>

        </form>
      </div>

      <div class="box_pop_add_user_footer">
        <button class="btn-submit" name="add_nhansu" data-id_phongban="{id_phongban}">Thêm nhân viên</button>
      </div>

    </div>
  </div>
</div>

<style>
  /* box_pop_add_user.css - CSS thuần cho modal thêm nhân sự */

  /* Reset nhỏ để đảm bảo style nhất quán */
  .box_pop_add_user,
  .box_pop_add_user * {
    box-sizing: border-box;
    font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  /* Overlay / modal container */
  .box_pop_add_user {
    position: fixed;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(10, 10, 10, 0.45);
    z-index: 9999;
  }

  /* Dialog (kích thước tương tự modal-xl) */
  .box_pop_add_user_dialog {
    width: 100%;
    max-width: 1400px;
    background: transparent;
    animation: slideUp 0.3s ease;
  }

  @keyframes slideUp {
    from {
      transform: translateY(20px);
      opacity: 0;
    }
    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  /* Card nội dung */
  .box_pop_add_user_content {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 12px 30px rgba(12, 15, 30, 0.18);
    display: flex;
    flex-direction: column;
  }

  /* Header */
  .box_pop_add_user_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 14px;
    background: #ffffff;
    color: #111827;
    border-bottom: 1px solid #e5e7eb;
  }

  .box_pop_add_user_title {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #111827;
  }

  .box_pop_add_user_close {
    width: 28px;
    height: 28px;
    background: #f3f4f6;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    flex-shrink: 0;
  }

  .box_pop_add_user_close i {
    font-size: 16px;
    font-family: "FontAwesome" !important;
  }

  .box_pop_add_user_close:hover {
    background: #e5e7eb;
    color: #374151;
    transform: scale(1.05);
  }

  .box_pop_add_user_close:active {
    transform: scale(0.95);
  }

  /* Body */
  .box_pop_add_user_body {
    padding: 18px 22px;
  }

  /* Grid layout: main + aside */
  .box_pop_add_user_grid {
    display: grid;
    grid-template-columns: 1fr 270px;
    gap: 20px;
    align-items: start;
  }

  /* Main column */
  .box_pop_add_user_main {}

  /* Fields wrapper */
  .box_pop_add_user_fields {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
  }

  /* Field sizes */
  .field {
    display: flex;
    flex-direction: column;
  }

  .field_half {}

  .field_full {
    grid-column: 1 / -1;
  }

  /* Labels and inputs */
  .field_label {
    font-size: 13px;
    color: #374151;
    margin-bottom: 6px;
    font-weight: 500;
  }

  .field_input {
    height: 40px;
    padding: 8px 10px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
    outline: none;
    background: #fff;
  }

  .field_input[type="file"] {
    padding: 6px 8px;
    height: auto;
  }

  /* Small top margin utility */
  .mt-small {
    margin-top: 8px;
  }

  /* Radio group */
  .radio-group {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
  }

  .radio {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #374151;
  }

  .radio input {
    width: 16px;
    height: 16px;
  }

  /* Aside (avatar + button) */
  .box_pop_add_user_aside {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
  }

  .avatar-placeholder {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: #f3f3f3;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    border: 2px solid #ddd;
  }

  .avatar-placeholder img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* Button styles */
  .btn-choose-photo,
  .btn-submit {
    display: inline-block;
    border: none;
    padding: 8px 14px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    background: #0d6efd;
    /* bootstrap primary-like */
    color: #fff;
    min-width: 120px;
  }

  .btn-choose-photo {
    font-size: 13px;
    padding: 7px 12px;
    width: 80%;
  }

  .btn-submit {
    background: #16a34a;
    padding: 9px 16px;
  }

  /* Footer */
  .box_pop_add_user_footer {
    padding: 14px 20px;
    border-top: 1px solid #eef0f2;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    background: #fff;
  }

  /* Responsive: stack columns on small screens */
  @media (max-width: 880px) {
    .box_pop_add_user_grid {
      grid-template-columns: 1fr;
    }

    .box_pop_add_user_fields {
      grid-template-columns: 1fr;
    }

    .box_pop_add_user_aside {
      flex-direction: row;
      gap: 12px;
      justify-content: space-between;
      width: 100%;
    }

    .btn-choose-photo {
      width: auto;
      min-width: 120px;
    }
  }

  /* Small accessibility focus */
  .field_input:focus,
  .box_pop_add_user_close:focus,
  .btn-choose-photo:focus,
  .btn-submit:focus {
    box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.12);
    outline: none;
  }
</style>
<script>
  document.getElementById('input_avatar').addEventListener('change', function (event) {
    const file = event.target.files[0];

    if (file) {
      const imgPreview = document.getElementById('preview_avatar');
      const icon = document.getElementById('avatar_icon');

      imgPreview.src = URL.createObjectURL(file);
      imgPreview.style.display = 'block';

      icon.style.display = 'none';
    }
  });
</script>