@extends('layouts.admin')

@section('title', 'Trang Chủ - Hệ Thống ISO')

@section('content')
<div class="container">
    <div class="home-layout">
        <!-- Left Column - Main Sections -->
        <div class="home-layout__left">
            <!-- Process Search Section -->
            <section class="process-search">
                <h2 class="process-search__title">TÌM KIẾM QUY TRÌNH</h2>
                <div class="process-search__content">
                    <div class="search-form">
                        <div class="search-form__group">
                            <label for="process-type" class="search-form__label">Chọn loại quy trình</label>
                            <select id="process-type" class="search-form__select select2-dropdown">
                                <option value="">-- Chọn loại quy trình --</option>
                                <option value="he-thong">Quy trình hệ thống</option>
                                <option value="tac-nghiep">Quy trình tác nghiệp</option>
                            </select>
                        </div>
                        <div class="search-form__group">
                            <label for="department" class="search-form__label">Chọn cơ quan, phân xưởng</label>
                            <select id="department" class="search-form__select select2-dropdown">
                                <option value="">-- Chọn cơ quan, phân xưởng --</option>
                                <option value="tat-ca">Tất cả</option>
                                @foreach($departments ?? [] as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="search-form__group">
                            <button type="button" class="search-form__btn" onclick="searchProcess()">Tìm kiếm</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Quality Manual Section -->
            <section class="quality-manual">
                <h2 class="quality-manual__title">SỔ TAY CHẤT LƯỢNG</h2>
                <div class="quality-manual__content">
                    <p class="quality-manual__text">
                        <strong>Sổ tay chất lượng</strong> là tài liệu tổng quát về Hệ thống quản lý chất lượng của Nhà máy A31/Quân chủng PKKQ, xác định phạm vi áp dụng; chính sách và mục tiêu chất lượng; giới thiệu hoạt động và cơ cấu tổ chức, chức năng nhiệm vụ của Nhà máy; nêu quan điểm của lãnh đạo, chỉ huy đối với việc tuân thủ các yêu cầu của Hệ thống quản lý chất lượng theo tiêu chuẩn quốc gia ISO 9001:2015; danh mục các quy trình, thủ tục đã ban hành để lãnh đạo, chỉ huy và cán bộ chủ chốt của cơ quan, đơn vị trực thuộc triển khai thực hiện, làm cơ sở điều hành Hệ thống quản lý chất lượng trong đơn vị.
                    </p>
                    <a href="/iso-system-documents?category_id=1" class="quality-manual__link"><strong>Xem thêm...</strong></a>
                </div>
            </section>

            <!-- Process Sections -->
            <section class="process-sections">
                <div class="process-sections__grid">
                    <!-- System Process -->
                    <div class="process-section">
                        <h2 class="process-section__title">QUY TRÌNH HỆ THỐNG</h2>
                        <div class="process-section__content">
                            <div class="process-list">
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-HT-01</span>
                                    <span class="process-list__name">Quy trình Kiểm soát thông tin dạng văn bản</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-HT-02</span>
                                    <span class="process-list__name">Quy trình Đánh giá nội bộ</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-HT-03</span>
                                    <span class="process-list__name">Quy trình Xem xét của lãnh đạo</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-HT-04</span>
                                    <span class="process-list__name">Quy trình Kiểm soát sự không phù hợp; hành động khắc phục, cải tiến</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-HT-05</span>
                                    <span class="process-list__name">Quy trình Quản lý rủi ro và cơ hội</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-HT-06</span>
                                    <span class="process-list__name">Quy trình Khiếu nại và đo lường sự thỏa mãn của khách hàng</span>
                                </div>
                            </div>
                            <div class="process-section__footer">
                                <a href="/iso-system-documents?category_id=2" class="process-section__link"><strong>Xem thêm...</strong></a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Operational Process -->
                    <div class="process-section">
                        <h2 class="process-section__title">QUY TRÌNH TÁC NGHIỆP</h2>
                        <div class="process-section__content">
                            <div class="process-list">
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-NV-01</span>
                                    <span class="process-list__name">Quy trình Lập và theo dõi kế hoạch sản xuất kinh doanh</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-NV-02</span>
                                    <span class="process-list__name">Quy trình Tổ chức triển khai và nghiệm thu sửa chữa, sản xuất thiết bị, vật tư kỹ thuật</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-NV-03</span>
                                    <span class="process-list__name">Quy trình Quản lý phương tiện đo</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-NV-04</span>
                                    <span class="process-list__name">Quy trình Kiểm soát ATLĐ-VSMT-PCCN</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-NV-05</span>
                                    <span class="process-list__name">Quy trình bảo dưỡng và sửa chữa thiết bị</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-NV-05</span>
                                    <span class="process-list__name">Quy trình Tổ chức huấn luyện kỹ thuật</span>
                                </div>
                            </div>
                            <div class="process-section__footer">
                                <a href="/iso-system-documents?category_id=3" class="process-section__link"><strong>Xem thêm...</strong></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="home-layout__right">
            <!-- Notifications Section -->
            <section class="notifications">
                <h2 class="notifications__title">THÔNG BÁO</h2>
                <div class="notifications__content">
                    <div class="news-list">
                        <div class="news-item">
                            <div class="news-item__date">28/08/2024</div>
                            <a href="#" class="news-item__title">Thông báo về việc triển khai hệ thống ISO mới</a>
                        </div>
                        <div class="news-item">
                            <div class="news-item__date">26/08/2024</div>
                            <a href="#" class="news-item__title">Lịch đào tạo về quy trình chất lượng tháng 9</a>
                        </div>
                        <div class="news-item">
                            <div class="news-item__date">24/08/2024</div>
                            <a href="#" class="news-item__title">Thông báo kiểm tra nội bộ định kỳ quý III</a>
                        </div>
                        <div class="news-item">
                            <div class="news-item__date">21/08/2024</div>
                            <a href="#" class="news-item__title">Hướng dẫn sử dụng hệ thống tài liệu điện tử</a>
                        </div>
                    </div>
                    <div class="notifications__footer">
                        <a href="/management-documents" class="notifications__more">Xem tất cả →</a>
                    </div>
                </div>
            </section>

            <!-- New Process Section -->
            <section class="new-process">
                <h2 class="new-process__title">QUY TRÌNH MỚI</h2>
                <div class="new-process__content">
                    <div class="news-list">
                        <div class="news-item">
                            <div class="news-item__date">28/08/2024</div>
                            <a href="#" class="news-item__title">Quy trình mới về quản lý chất lượng ISO 9001:2015</a>
                        </div>
                        <div class="news-item">
                            <div class="news-item__date">25/08/2024</div>
                            <a href="#" class="news-item__title">Cập nhật quy trình đánh giá nội bộ</a>
                        </div>
                        <div class="news-item">
                            <div class="news-item__date">22/08/2024</div>
                            <a href="#" class="news-item__title">Quy trình mới về xử lý khiếu nại khách hàng</a>
                        </div>
                        <div class="news-item">
                            <div class="news-item__date">20/08/2024</div>
                            <a href="#" class="news-item__title">Hướng dẫn quy trình cải tiến liên tục</a>
                        </div>
                    </div>
                    <div class="new-process__footer">
                        <a href="/iso-system-documents" class="new-process__more">Xem tất cả →</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
// Wait for both jQuery and Select2 to load
window.addEventListener('load', function() {
    if (typeof jQuery !== 'undefined' && typeof jQuery().select2 !== 'undefined') {
        jQuery(document).ready(function($) {
            // Initialize Select2 for department dropdown
            $('#department').select2({
                placeholder: '-- Chọn cơ quan, phân xưởng --',
                allowClear: true,
                dropdownAutoWidth: false,
                maximumResultsForSearch: 5,
                dropdownCssClass: 'select2-dropdown-small',
                containerCssClass: 'select2-container-small'
            });
            
            // Initialize Select2 for process type dropdown
            $('#process-type').select2({
                placeholder: '-- Chọn loại quy trình --',
                allowClear: true,
                dropdownAutoWidth: false,
                minimumResultsForSearch: Infinity, // Disable search for this dropdown
                dropdownCssClass: 'select2-dropdown-small',
                containerCssClass: 'select2-container-small'
            });
        });
    } else {
        console.error('jQuery or Select2 not loaded');
    }
});

function searchProcess() {
    const processType = document.getElementById('process-type').value;
    const department = document.getElementById('department').value;
    
    if (!processType) {
        showModal('Thông báo', 'Vui lòng chọn loại quy trình!', 'warning');
        return;
    }
    
    let url = '/iso-system-documents';
    let params = [];
    
    // Xác định category_id dựa trên loại quy trình
    if (processType === 'he-thong') {
        params.push('category_id=2'); // Quy trình hệ thống
    } else if (processType === 'tac-nghiep') {
        params.push('category_id=3'); // Quy trình tác nghiệp
    }
    
    // Thêm department filter nếu có chọn
    if (department && department !== 'tat-ca' && department !== '') {
        params.push('department_id=' + encodeURIComponent(department));
    }
    
    // Tạo URL với parameters
    if (params.length > 0) {
        url += '?' + params.join('&');
    }
    
    // Chuyển đến trang tài liệu ISO
    window.location.href = url;
}

// Modal function for notifications
function showModal(title, message, type = 'info') {
    // Create modal HTML
    const modalHtml = `
        <div class="modal-overlay" id="notification-modal">
            <div class="modal-container">
                <div class="modal-header ${type}">
                    <h3 class="modal-title">${title}</h3>
                    <button type="button" class="modal-close" onclick="closeModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="modal-icon ${type}">
                        ${type === 'warning' ? '⚠️' : type === 'error' ? '❌' : 'ℹ️'}
                    </div>
                    <p class="modal-message">${message}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="closeModal()">Đóng</button>
                </div>
            </div>
        </div>
    `;
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Show modal with animation
    setTimeout(() => {
        document.getElementById('notification-modal').classList.add('show');
    }, 10);
}

function closeModal() {
    const modal = document.getElementById('notification-modal');
    if (modal) {
        modal.classList.remove('show');
        setTimeout(() => {
            modal.remove();
        }, 300);
    }
}
</script>

<style>
.select2-dropdown-small .select2-results__options {
    max-height: 150px !important;
    overflow-y: auto !important;
}

.select2-container-small .select2-selection--single {
    height: 35px !important;
    border: 1px solid #d0d0d0 !important;
    border-radius: 4px !important;
}

.select2-container-small .select2-selection--single .select2-selection__rendered {
    line-height: 33px !important;
    padding: 8px 12px !important;
    font-size: 13px !important;
    color: #666 !important;
}

.select2-container-small .select2-selection--single .select2-selection__arrow {
    height: 33px !important;
}

/* Target Select2 container with actual generated classes */
.search-form__group .select2-container.select2-container--default {
    width: 100% !important;
    max-width: 100% !important;
    min-width: 100% !important;
}

.search-form__group .select2-container.select2-container--default .select2-selection.select2-selection--single {
    height: 35px !important;
    width: 100% !important;
    line-height: 33px !important;
    box-sizing: border-box !important;
}

.search-form__group .select2-container.select2-container--default .select2-selection__rendered {
    line-height: 33px !important;
    padding-left: 12px !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    font-size: 13px !important;
    color: #666666 !important;
}

.search-form__group .select2-container.select2-container--default .select2-selection__arrow {
    height: 33px !important;
}

.search-form__group .select2-container--default .select2-selection--single .select2-selection__placeholder {
    font-size: 13px !important;
    color: #666666 !important;
}

.search-form__group .select2-container--default .select2-selection--single .select2-selection__clear {
    position: absolute !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    right: 0 !important;
    line-height: 1 !important;
}

/* Modal styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

.modal-container {
    background: white;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    max-width: 400px;
    width: 90%;
    transform: translateY(-20px);
    transition: transform 0.3s ease;
}

.modal-overlay.show .modal-container {
    transform: translateY(0);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
    border-radius: 8px 8px 0 0;
}

.modal-header.warning {
    background-color: #fff3cd;
    border-color: #ffeaa7;
}

.modal-header.error {
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.modal-header.info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
}

.modal-title {
    margin: 0;
    font-size: 16px;
    font-weight: bold;
    color: #333;
}

.modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #666;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background-color 0.2s;
}

.modal-close:hover {
    background-color: rgba(0, 0, 0, 0.1);
}

.modal-body {
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.modal-icon {
    font-size: 30px;
    flex-shrink: 0;
}

.modal-message {
    margin: 0;
    color: #333;
    font-size: 14px;
    line-height: 1.4;
}

.modal-footer {
    padding: 15px 20px;
    border-top: 1px solid #eee;
    text-align: right;
    border-radius: 0 0 8px 8px;
}

.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 13px;
    transition: background-color 0.2s;
}

.btn-primary {
    background-color: #4682b4;
    color: white;
}

.btn-primary:hover {
    background-color: #315a7a;
}

.select2-dropdown-small {
    border: 1px solid #d0d0d0 !important;
    border-radius: 4px !important;
}

.select2-dropdown-small .select2-results__option {
    padding: 8px 12px !important;
    font-size: 13px !important;
}
</style>

@endsection