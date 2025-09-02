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

            <!-- System Process Section -->
            <section class="system-process">
                <h2 class="system-process__title">QUY TRÌNH HỆ THỐNG (Quy trình của BCĐ)</h2>
                <div class="system-process__content">
                    <div class="process-grid">
                        <div class="process-item">
                            <div class="process-item__header">
                                <h3 class="process-item__title">Quy trình quản lý chất lượng</h3>
                            </div>
                            <div class="process-item__content">
                                <p>Quy trình đảm bảo chất lượng sản phẩm và dịch vụ theo tiêu chuẩn ISO 9001:2015</p>
                                <a href="#" class="process-item__link">Xem chi tiết →</a>
                            </div>
                        </div>
                        
                        <div class="process-item">
                            <div class="process-item__header">
                                <h3 class="process-item__title">Quy trình đánh giá nội bộ</h3>
                            </div>
                            <div class="process-item__content">
                                <p>Quy trình kiểm tra và đánh giá hoạt động nội bộ của tổ chức</p>
                                <a href="#" class="process-item__link">Xem chi tiết →</a>
                            </div>
                        </div>
                        
                        <div class="process-item">
                            <div class="process-item__header">
                                <h3 class="process-item__title">Quy trình cải tiến liên tục</h3>
                            </div>
                            <div class="process-item__content">
                                <p>Quy trình cải thiện và nâng cao hiệu quả hoạt động của hệ thống</p>
                                <a href="#" class="process-item__link">Xem chi tiết →</a>
                            </div>
                        </div>
                        
                        <div class="process-item">
                            <div class="process-item__header">
                                <h3 class="process-item__title">Quy trình xử lý khiếu nại</h3>
                            </div>
                            <div class="process-item__content">
                                <p>Quy trình tiếp nhận và giải quyết khiếu nại của khách hàng</p>
                                <a href="#" class="process-item__link">Xem chi tiết →</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Operational Process Section -->
            <section class="operational-process">
                <h2 class="operational-process__title">QUY TRÌNH TÁC NGHIỆP (Quy trình áp dụng chung, có sự phối hợp giữa các đơn vị)</h2>
                <div class="operational-process__content">
                    <div class="process-grid">
                        <div class="process-item">
                            <div class="process-item__header">
                                <h3 class="process-item__title">Quy trình phối hợp liên ngành</h3>
                            </div>
                            <div class="process-item__content">
                                <p>Quy trình phối hợp công việc giữa các phòng ban và đơn vị trong tổ chức</p>
                                <a href="#" class="process-item__link">Xem chi tiết →</a>
                            </div>
                        </div>
                        
                        <div class="process-item">
                            <div class="process-item__header">
                                <h3 class="process-item__title">Quy trình xử lý công việc</h3>
                            </div>
                            <div class="process-item__content">
                                <p>Quy trình xử lý và giải quyết các công việc chung của toàn đơn vị</p>
                                <a href="#" class="process-item__link">Xem chi tiết →</a>
                            </div>
                        </div>
                        
                        <div class="process-item">
                            <div class="process-item__header">
                                <h3 class="process-item__title">Quy trình báo cáo định kỳ</h3>
                            </div>
                            <div class="process-item__content">
                                <p>Quy trình lập và báo cáo các hoạt động định kỳ theo quy định</p>
                                <a href="#" class="process-item__link">Xem chi tiết →</a>
                            </div>
                        </div>
                        
                        <div class="process-item">
                            <div class="process-item__header">
                                <h3 class="process-item__title">Quy trình quản lý tài liệu</h3>
                            </div>
                            <div class="process-item__content">
                                <p>Quy trình quản lý và lưu trữ tài liệu chung của đơn vị</p>
                                <a href="#" class="process-item__link">Xem chi tiết →</a>
                            </div>
                        </div>
                        
                        <div class="process-item">
                            <div class="process-item__header">
                                <h3 class="process-item__title">Quy trình đào tạo chung</h3>
                            </div>
                            <div class="process-item__content">
                                <p>Quy trình đào tạo và nâng cao năng lực cho cán bộ công chức</p>
                                <a href="#" class="process-item__link">Xem chi tiết →</a>
                            </div>
                        </div>
                        
                        <div class="process-item">
                            <div class="process-item__header">
                                <h3 class="process-item__title">Quy trình kiểm soát chất lượng</h3>
                            </div>
                            <div class="process-item__content">
                                <p>Quy trình kiểm soát và đảm bảo chất lượng công việc liên đơn vị</p>
                                <a href="#" class="process-item__link">Xem chi tiết →</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Internal Process Section -->
            <section class="internal-process">
                <h2 class="internal-process__title">QUY TRÌNH NỘI BỘ (Chỉ áp dụng nội bộ trong cơ quan, phân xưởng)</h2>
                <div class="internal-process__content">
                    <div class="process-grid">
                        <div class="process-item">
                            <div class="process-item__header">
                                <h3 class="process-item__title">Quy trình nội bộ văn phòng</h3>
                            </div>
                            <div class="process-item__content">
                                <p>Các quy trình làm việc nội bộ riêng của từng phòng ban trong đơn vị</p>
                                <a href="#" class="process-item__link">Xem chi tiết →</a>
                            </div>
                        </div>
                        
                        <div class="process-item">
                            <div class="process-item__header">
                                <h3 class="process-item__title">Quy trình chuyên môn kỹ thuật</h3>
                            </div>
                            <div class="process-item__content">
                                <p>Quy trình kỹ thuật chuyên ngành áp dụng riêng trong từng phân xưởng</p>
                                <a href="#" class="process-item__link">Xem chi tiết →</a>
                            </div>
                        </div>
                        
                        <div class="process-item">
                            <div class="process-item__header">
                                <h3 class="process-item__title">Quy trình quản lý nhân sự nội bộ</h3>
                            </div>
                            <div class="process-item__content">
                                <p>Quy trình quản lý và phân công công việc nội bộ từng bộ phận</p>
                                <a href="#" class="process-item__link">Xem chi tiết →</a>
                            </div>
                        </div>
                        
                        <div class="process-item">
                            <div class="process-item__header">
                                <h3 class="process-item__title">Quy trình kiểm tra nội bộ</h3>
                            </div>
                            <div class="process-item__content">
                                <p>Quy trình tự kiểm tra và đánh giá công việc trong nội bộ đơn vị</p>
                                <a href="#" class="process-item__link">Xem chi tiết →</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="home-layout__right">
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
                        <a href="#" class="new-process__more">Xem tất cả →</a>
                    </div>
                </div>
            </section>

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
                        <a href="#" class="notifications__more">Xem tất cả →</a>
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
        @if($processCategories['he_thong_id'])
            params.push('category_id={{ $processCategories["he_thong_id"] }}');
        @endif
    } else if (processType === 'tac-nghiep') {
        @if($processCategories['tac_nghiep_id'])
            params.push('category_id={{ $processCategories["tac_nghiep_id"] }}');
        @endif
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