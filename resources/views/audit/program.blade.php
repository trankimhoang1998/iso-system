@extends('layouts.admin')

@section('title', 'Đánh Giá Nội Bộ - Kế Hoạch')

@section('content')
<div class="container audit-program">
    <div class="page-header">
        <h1 class="page-header__title">KẾ HOẠCH ĐÁNH GIÁ</h1>
        <div class="page-header__breadcrumb">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span class="breadcrumb-separator">></span>
            <a href="{{ route('admin.audit.summary') }}">Đánh giá nội bộ</a>
            <span class="breadcrumb-separator">></span>
            <span>Kế hoạch</span>
        </div>
    </div>


    <!-- Current Plans -->
    <div class="section">
        <div class="section__header">
            <h2 class="section__title">Kế hoạch đánh giá năm 2024</h2>
            <div class="section__actions">
                <div class="section__filters">
                    <select class="form-select form-select--compact">
                        <option value="2024">Năm 2024</option>
                        <option value="2023">Năm 2023</option>
                    </select>
                    <select class="form-select form-select--compact">
                        <option value="">Tất cả tháng</option>
                        <option value="12">Tháng 12</option>
                        <option value="11">Tháng 11</option>
                        <option value="10">Tháng 10</option>
                        <option value="9">Tháng 9</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary" data-modal-target="create-plan-modal">
                    <span class="btn-icon">📋</span>
                    Tạo kế hoạch đánh giá mới
                </button>
            </div>
        </div>

        <div class="audit-timeline">
            <!-- December 2024 -->
            <div class="timeline-month">
                <h3 class="timeline-month__title">THÁNG 12/2024</h3>

                <div class="audit-cards">
                    <div class="audit-card">
                        <div class="audit-card__header">
                            <h4 class="audit-card__title">Đánh giá nội bộ Phòng Nhân sự</h4>
                            <span class="audit-card__status audit-card__status--planning">Kế hoạch</span>
                        </div>
                        <div class="audit-card__content">
                            <div class="audit-card__info">
                                <div class="info-item">
                                    <strong>Bộ phận:</strong> Phòng Nhân sự
                                </div>
                                <div class="info-item">
                                    <strong>Ngày thực hiện:</strong> 10/12/2024 - 15/12/2024
                                </div>
                                <div class="info-item">
                                    <strong>Đánh giá viên:</strong> Trần Thị B
                                </div>
                                <div class="info-item">
                                    <strong>Phạm vi:</strong> Quy trình tuyển dụng, đào tạo và đánh giá nhân viên
                                </div>
                            </div>
                            <div class="audit-card__actions">
                                <button class="btn btn-sm btn-outline">Sửa</button>
                                <button class="btn btn-sm btn-primary">Bắt đầu</button>
                            </div>
                        </div>
                    </div>

                    <div class="audit-card">
                        <div class="audit-card__header">
                            <h4 class="audit-card__title">Đánh giá nội bộ Phòng QLCL</h4>
                            <span class="audit-card__status audit-card__status--planning">Kế hoạch</span>
                        </div>
                        <div class="audit-card__content">
                            <div class="audit-card__info">
                                <div class="info-item">
                                    <strong>Bộ phận:</strong> Phòng Quản lý Chất lượng
                                </div>
                                <div class="info-item">
                                    <strong>Ngày thực hiện:</strong> 20/12/2024 - 25/12/2024
                                </div>
                                <div class="info-item">
                                    <strong>Đánh giá viên:</strong> Nguyễn Văn A
                                </div>
                                <div class="info-item">
                                    <strong>Phạm vi:</strong> Hệ thống quản lý chất lượng ISO 9001
                                </div>
                            </div>
                            <div class="audit-card__actions">
                                <button class="btn btn-sm btn-outline">Sửa</button>
                                <button class="btn btn-sm btn-primary">Bắt đầu</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- November 2024 -->
            <div class="timeline-month">
                <h3 class="timeline-month__title">THÁNG 11/2024</h3>

                <div class="audit-cards">
                    <div class="audit-card">
                        <div class="audit-card__header">
                            <h4 class="audit-card__title">Đánh giá nội bộ Phòng Kỹ thuật</h4>
                            <span class="audit-card__status audit-card__status--completed">Hoàn thành</span>
                        </div>
                        <div class="audit-card__content">
                            <div class="audit-card__info">
                                <div class="info-item">
                                    <strong>Bộ phận:</strong> Phòng Kỹ thuật
                                </div>
                                <div class="info-item">
                                    <strong>Ngày thực hiện:</strong> 15/11/2024 - 20/11/2024
                                </div>
                                <div class="info-item">
                                    <strong>Đánh giá viên:</strong> Lê Văn C
                                </div>
                                <div class="info-item">
                                    <strong>Kết quả:</strong> 3 phát hiện, 2 khuyến nghị cải tiến
                                </div>
                            </div>
                            <div class="audit-card__actions">
                                <button class="btn btn-sm btn-outline">Xem báo cáo</button>
                                <button class="btn btn-sm btn-success">Đã hoàn thành</button>
                            </div>
                        </div>
                    </div>

                    <div class="audit-card">
                        <div class="audit-card__header">
                            <h4 class="audit-card__title">Đánh giá nội bộ Phòng KHCN</h4>
                            <span class="audit-card__status audit-card__status--active">Đang thực hiện</span>
                        </div>
                        <div class="audit-card__content">
                            <div class="audit-card__info">
                                <div class="info-item">
                                    <strong>Bộ phận:</strong> Phòng Khoa học Công nghệ
                                </div>
                                <div class="info-item">
                                    <strong>Ngày thực hiện:</strong> 25/11/2024 - 30/11/2024
                                </div>
                                <div class="info-item">
                                    <strong>Đánh giá viên:</strong> Phạm Văn D
                                </div>
                                <div class="info-item">
                                    <strong>Tiến độ:</strong> 75% - Đang thu thập dữ liệu
                                </div>
                            </div>
                            <div class="audit-card__actions">
                                <button class="btn btn-sm btn-outline">Cập nhật</button>
                                <button class="btn btn-sm btn-warning">Theo dõi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="section">
        <h3 class="section__title">Thống kê kế hoạch</h3>
        <div class="stats-grid">
            <div class="stats-card stats-card--small">
                <div class="stats-card__content">
                    <h4 class="stats-card__title">Tổng kế hoạch</h4>
                    <p class="stats-card__value">12</p>
                    <p class="stats-card__subtitle">Năm 2024</p>
                </div>
            </div>
            <div class="stats-card stats-card--small">
                <div class="stats-card__content">
                    <h4 class="stats-card__title">Đã hoàn thành</h4>
                    <p class="stats-card__value">8</p>
                    <p class="stats-card__subtitle">66.7%</p>
                </div>
            </div>
            <div class="stats-card stats-card--small">
                <div class="stats-card__content">
                    <h4 class="stats-card__title">Đang thực hiện</h4>
                    <p class="stats-card__value">3</p>
                    <p class="stats-card__subtitle">25%</p>
                </div>
            </div>
            <div class="stats-card stats-card--small">
                <div class="stats-card__content">
                    <h4 class="stats-card__title">Kế hoạch</h4>
                    <p class="stats-card__value">1</p>
                    <p class="stats-card__subtitle">8.3%</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Plan Modal -->
<div id="create-plan-modal" class="program-modal">
    <div class="program-modal-backdrop" data-modal-close="create-plan-modal"></div>
    <div class="program-modal-container">
        <div class="program-modal-header">
            <h3 class="program-modal-title">Tạo kế hoạch đánh giá mới</h3>
            <button type="button" class="program-modal-close" data-modal-close="create-plan-modal">
                <span>&times;</span>
            </button>
        </div>

        <div class="program-modal-body">
            <form method="POST" action="#" class="audit-form-modal" id="create-plan-form">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="audit_name" class="form-label">Tên cuộc đánh giá *</label>
                        <input type="text" id="audit_name" name="audit_name" class="form-input"
                               placeholder="Ví dụ: Đánh giá nội bộ Phòng Kỹ thuật Q4/2024" required>
                    </div>

                    <div class="form-group">
                        <label for="department" class="form-label">Bộ phận/Phạm vi *</label>
                        <select id="department" name="department" class="form-select" required>
                            <option value="">Chọn bộ phận</option>
                            <option value="phong-ky-thuat">Phòng Kỹ thuật</option>
                            <option value="phong-khcn">Phòng KHCN</option>
                            <option value="phong-tai-chinh">Phòng Tài chính</option>
                            <option value="phong-nhan-su">Phòng Nhân sự</option>
                            <option value="phong-an-toan">Phòng An toàn</option>
                            <option value="phong-qlcl">Phòng QLCL</option>
                            <option value="ban-giam-doc">Ban Giám đốc</option>
                            <option value="toan-cong-ty">Toàn công ty</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="planned_date" class="form-label">Ngày dự kiến *</label>
                        <input type="date" id="planned_date" name="planned_date" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="end_date" class="form-label">Ngày kết thúc dự kiến</label>
                        <input type="date" id="end_date" name="end_date" class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="lead_auditor" class="form-label">Đánh giá viên phụ trách *</label>
                        <select id="lead_auditor" name="lead_auditor" class="form-select" required>
                            <option value="">Chọn đánh giá viên</option>
                            <option value="nguyen-van-a">Nguyễn Văn A</option>
                            <option value="tran-thi-b">Trần Thị B</option>
                            <option value="le-van-c">Lê Văn C</option>
                            <option value="pham-van-d">Phạm Văn D</option>
                            <option value="hoang-thi-e">Hoàng Thị E</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="auditor_team" class="form-label">Nhóm đánh giá</label>
                        <textarea id="auditor_team" name="auditor_team" rows="3" class="form-textarea"
                                  placeholder="Danh sách các thành viên tham gia đánh giá"></textarea>
                    </div>

                    <div class="form-group form-group--full">
                        <label for="scope" class="form-label">Phạm vi đánh giá</label>
                        <textarea id="scope" name="scope" rows="3" class="form-textarea"
                                  placeholder="Mô tả chi tiết phạm vi và mục tiêu đánh giá"></textarea>
                    </div>

                    <div class="form-group form-group--full">
                        <label for="notes" class="form-label">Ghi chú</label>
                        <textarea id="notes" name="notes" rows="2" class="form-textarea"
                                  placeholder="Ghi chú bổ sung"></textarea>
                    </div>
                </div>
            </form>
        </div>

        <div class="program-modal-footer">
            <button type="button" class="btn btn-outline" data-modal-close="create-plan-modal">Hủy bỏ</button>
            <button type="submit" form="create-plan-form" class="btn btn-primary">
                <span class="btn-icon">📋</span>
                Tạo kế hoạch
            </button>
        </div>
    </div>
</div>

<script>
// Modal functionality
document.addEventListener('DOMContentLoaded', function() {
    // Open modal
    document.querySelectorAll('[data-modal-target]').forEach(trigger => {
        trigger.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('program-modal--active');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    // Close modal
    document.querySelectorAll('[data-modal-close]').forEach(closeBtn => {
        closeBtn.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-close');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('program-modal--active');
                document.body.style.overflow = '';
                // Reset form
                const form = modal.querySelector('form');
                if (form) form.reset();
            }
        });
    });

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const activeModal = document.querySelector('.program-modal.program-modal--active');
            if (activeModal) {
                activeModal.classList.remove('program-modal--active');
                document.body.style.overflow = '';
            }
        }
    });
});
</script>
@endsection