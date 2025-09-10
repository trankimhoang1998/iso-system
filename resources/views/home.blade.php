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
                        <strong>Sổ tay chất lượng</strong> là tài liệu tổng quát về Hệ thống quản lý chất lượng của Nhà máy A31/Quân chủng Phòng không-Không quân, xác định phạm vi áp dụng; chính sách và mục tiêu chất lượng; giới thiệu hoạt động và cơ cấu tổ chức, chức năng nhiệm vụ của Nhà máy; nêu quan điểm của lãnh đạo, chỉ huy đối với việc tuân thủ các yêu cầu của Hệ thống quản lý chất lượng theo tiêu chuẩn quốc gia TCVN ISO 9001:2015; danh mục các quy trình, thủ tục đã ban hành để lãnh đạo, chỉ huy và cán bộ chủ chốt của cơ quan, đơn vị trực thuộc triển khai thực hiện, làm cơ sở điều hành Hệ thống quản lý chất lượng trong đơn vị.
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
                                    <span class="process-list__name">Quy trình Bảo dưỡng và sửa chữa thiết bị</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-NV-06</span>
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
                        @forelse($notifications as $notification)
                        <div class="news-item">
                            <div class="news-item__date">{{ $notification->issue_date->format('d/m/Y') }}</div>
                            <a href="{{ $notification->document_link }}" target="_blank" class="news-item__title">{{ $notification->title }}</a>
                        </div>
                        @empty
                        <div class="news-item">
                            <div class="news-item__date">--/--/----</div>
                            <span class="news-item__title">Chưa có thông báo nào</span>
                        </div>
                        @endforelse
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
                        @forelse($newProcesses as $newProcess)
                        <div class="news-item">
                            <div class="news-item__date">{{ $newProcess->issue_date->format('d/m/Y') }}</div>
                            <a href="{{ $newProcess->document_link }}" target="_blank" class="news-item__title">{{ $newProcess->title }}</a>
                        </div>
                        @empty
                        <div class="news-item">
                            <div class="news-item__date">--/--/----</div>
                            <span class="news-item__title">Chưa có quy trình mới nào</span>
                        </div>
                        @endforelse
                    </div>
                    <div class="new-process__footer">
                        <a href="/iso-system-documents/category/4" class="new-process__more">Xem tất cả →</a>
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

@endsection