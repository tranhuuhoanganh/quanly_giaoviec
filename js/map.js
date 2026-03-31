var map = L.map('map').setView([16, 105], 5);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

var allMarkers = []; 
var markerMap = new Map();

function loadAllBookings() {
    $.ajax({
        url: "/members/process.php",
        type: "POST",
        data: { action: "booking_map" },
        success: function (response) {
            try {
                var info = JSON.parse(response);
                const list_hang_nhap = info.list_hang_nhap;
                const list_hang_xuat = info.list_hang_xuat;
                const list_hang_noi_dia = info.list_hang_noi_dia;

                let delay = 0;
                list_hang_nhap.forEach(entry => {
                    setTimeout(() => geocodeAndAddMarker(entry, 'blue', 'hangnhap'), delay);
                    delay += 500;
                });
                list_hang_xuat.forEach(entry => {
                    setTimeout(() => geocodeAndAddMarker(entry, 'orange', 'hangxuat'), delay);
                    delay += 500;
                });
                list_hang_noi_dia.forEach(entry => {
                    setTimeout(() => geocodeAndAddMarker(entry, 'red', 'hang_noidia'), delay);
                    delay += 500;
                });
            } catch (error) {
                console.error("Lỗi phân tích dữ liệu:", error);
            }
        },
        error: function (xhr, status, error) {
            console.error("Lỗi trong yêu cầu AJAX:", error);
        }
    });
}

loadAllBookings();

function geocodeAndAddMarker(entry, color, label, retryCount = 3) {
    const address = `${entry.ten_xa}, ${entry.ten_huyen}, ${entry.ten_tinh}`;
    const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                const { lat, lon } = data[0];
                const position = `${lat},${lon}`;

                if (markerMap.has(position)) {
                    const markerData = markerMap.get(position);
                    markerData.count++;
                    const newPopupContent = `<ul>
                        <li><strong>Địa điểm:</strong> ${entry.ten_xa}, ${entry.ten_huyen}, ${entry.ten_tinh}</li>
                        <li><strong>Loại hình:</strong> ${label}</li>
                        <li><strong>Tổng booking:</strong> ${markerData.count}</li>
                    </ul>`;
                    markerData.marker.setPopupContent(newPopupContent);
                } else {
                    const popupContent = `<ul>
                        <li><strong>Địa điểm:</strong> ${entry.ten_xa}, ${entry.ten_huyen}, ${entry.ten_tinh}</li>
                        <li><strong>Loại hình:</strong> ${label}</li>
                        <li><strong>Tổng booking:</strong> 1</li>
                    </ul>`;

                    const marker = L.circleMarker([lat, lon], {
                        color: color,
                        radius: 8
                    }).addTo(map).bindPopup(popupContent);

                    allMarkers.push(marker);
                    markerMap.set(position, { marker: marker, count: 1 });
                }
            } else {
                console.warn(`Không tìm thấy vị trí cho địa chỉ: ${address}`);
            }
        })
        .catch(error => {
            if (retryCount > 0) {
                console.warn(`Thử lại cho địa chỉ: ${address}. Còn lại ${retryCount} lần thử...`);
                setTimeout(() => geocodeAndAddMarker(entry, color, label, retryCount - 1), 1000);
            } else {
                console.error(`Lỗi khi tìm tọa độ cho địa chỉ: ${address}`, error);
            }
        });
}

// Search functionality
// Search functionality
document.getElementById('search-btn').addEventListener('click', () => {
    const province = document.getElementById('province-input').value.trim();
    const district = document.getElementById('district-select').value.trim();

    let query = district ? `${district}, ${province}` : province; // Chỉ sử dụng tỉnh và huyện

    if (query) {
        const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    const { lat, lon } = data[0];
                    const zoomLevel = district ? 15 : 12; // Zoom dựa trên huyện hoặc tỉnh
                    map.setView([lat, lon], zoomLevel);
                } else {
                    alert("Không tìm thấy vị trí phù hợp. Vui lòng thử lại.");
                }
            })
            .catch(error => {
                console.error("Lỗi khi tìm kiếm địa điểm:", error);
            });
    } else {
        alert("Vui lòng nhập ít nhất tên tỉnh/thành phố.");
    }
});


// Resize map on window resize
setTimeout(() => { map.invalidateSize(); }, 2000);
window.onresize = () => {
    setTimeout(() => { map.invalidateSize(); }, 3000);
};
