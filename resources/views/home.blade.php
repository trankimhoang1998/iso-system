@extends('layouts.app')

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
                            <select id="process-type" class="search-form__select">
                                <option value="">-- Chọn loại quy trình --</option>
                                <option value="he-thong">Quy trình hệ thống</option>
                                <option value="tac-nghiep">Quy trình tác nghiệp</option>
                            </select>
                        </div>
                        <div class="search-form__group">
                            <label for="department" class="search-form__label">Chọn cơ quan, phân xưởng</label>
                            <select id="department" class="search-form__select">
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
                        Sổ tay chất lượng là tài liệu tổng quát về Hệ thống quản lý chất lượng của Nhà máy A31, xác định phạm vi áp dụng; chính sách và mục tiêu chất lượng; giới thiệu hoạt động và cơ cấu tổ chức, chức năng nhiệm vụ của Nhà máy; nêu quan điểm của lãnh đạo, chỉ huy Nhà máy đối với việc tuân thủ các yêu cầu của Hệ thống quản lý chất lượng theo TCVN ISO 9001:2015; danh mục các quy trình, thủ tục đã ban hành trong Nhà máy để lãnh đạo, chỉ huy và cán bộ chủ chốt của cơ quan, đơn vị trực thuộc triển khai thực hiện, làm cơ sở điều hành Hệ thống quản lý chất lượng của Nhà máy A31.
                    </p>
                    <a href="/admin/iso-system-documents?category_id=1" class="quality-manual__link"><strong>Xem thêm...</strong></a>
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
                                    <span class="process-list__name">Quy trình quản lý chất lượng</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-HT-02</span>
                                    <span class="process-list__name">Quy trình đánh giá nội bộ</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-HT-03</span>
                                    <span class="process-list__name">Quy trình cải tiến liên tục</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-HT-04</span>
                                    <span class="process-list__name">Quy trình xử lý khiếu nại</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-HT-05</span>
                                    <span class="process-list__name">Quy trình quản lý tài liệu</span>
                                </div>
                            </div>
                            <div class="process-section__footer">
                                <a href="/admin/iso-system-documents?category_id=2" class="process-section__link"><strong>Xem thêm...</strong></a>
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
                                    <span class="process-list__name">Quy trình sản xuất chính</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-NV-02</span>
                                    <span class="process-list__name">Quy trình kiểm tra chất lượng</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-NV-03</span>
                                    <span class="process-list__name">Quy trình bảo trì thiết bị</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-NV-04</span>
                                    <span class="process-list__name">Quy trình an toàn lao động</span>
                                </div>
                                <div class="process-list__item">
                                    <span class="process-list__code">QT-NV-05</span>
                                    <span class="process-list__name">Quy trình giao nhận sản phẩm</span>
                                </div>
                            </div>
                            <div class="process-section__footer">
                                <a href="/admin/iso-system-documents?category_id=3" class="process-section__link"><strong>Xem thêm...</strong></a>
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
                        <a href="/admin/management-documents" class="notifications__more">Xem tất cả →</a>
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
                        <a href="/admin/iso-system-documents" class="new-process__more">Xem tất cả →</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
function searchProcess() {
    const processType = document.getElementById('process-type').value;
    const department = document.getElementById('department').value;
    
    if (!processType) {
        alert('Vui lòng chọn loại quy trình!');
        return;
    }
    
    let url = '/admin/iso-system-documents';
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
</script>

@endsection