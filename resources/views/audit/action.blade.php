@extends('layouts.admin')

@section('title', 'Đánh Giá Nội Bộ - Hành Động Khắc Phục')

@section('content')
<div class="container audit-action">
    <div class="page-header">
        <h1 class="page-header__title">ĐÁNH GIÁ NỘI BỘ - TỔNG HỢP</h1>
        <div class="page-header__breadcrumb">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span class="breadcrumb-separator">></span>
            <a href="{{ route('admin.audit.summary') }}">Đánh giá nội bộ</a>
            <span class="breadcrumb-separator">></span>
            <span>Tổng hợp</span>
        </div>
    </div>

    <!-- Notifications Section -->
    <div class="section">
        <div class="section__header">
            <h2 class="section__title">Thông báo khắc phục</h2>
            <div class="section__actions">
                <div class="notification-summary">
                    <span class="notification-count notification-count--urgent">3 Khẩn cấp</span>
                    <span class="notification-count notification-count--pending">7 Chờ xử lý</span>
                </div>
                <button type="button" class="btn btn-primary" data-modal-target="create-action-modal">
                    <span class="btn-icon">📋</span>
                    Tạo hành động khắc phục mới
                </button>
            </div>
        </div>

        <div class="notifications-container">
            <div class="notification-card notification-card--urgent">
                <div class="notification-card__header">
                    <div class="notification-info">
                        <span class="notification-code">NC-2024-003</span>
                        <span class="notification-title">Điểm không phù hợp nghiêm trọng - Hệ thống quản lý rủi ro</span>
                    </div>
                    <div class="notification-meta">
                        <span class="notification-department">Phòng QLCL</span>
                        <span class="notification-date">20/12/2024</span>
                    </div>
                </div>
                <div class="notification-card__content">
                    <p class="notification-description">
                        Chưa có quy trình quản lý rủi ro và cơ hội một cách hệ thống. Thiếu đánh giá rủi ro cho các quy trình quan trọng.
                    </p>
                    <div class="notification-actions">
                        <button class="btn btn-sm btn-outline">Chi tiết</button>
                        <button class="btn btn-sm btn-warning" data-modal-target="response-modal" data-notification="NC-2024-003">
                            Phản hồi ngay
                        </button>
                    </div>
                </div>
            </div>

            <div class="notification-card notification-card--normal">
                <div class="notification-card__header">
                    <div class="notification-info">
                        <span class="notification-code">NC-2024-002</span>
                        <span class="notification-title">Điểm không phù hợp - Phạm vi QMS chưa đầy đủ</span>
                    </div>
                    <div class="notification-meta">
                        <span class="notification-department">Phòng KHCN</span>
                        <span class="notification-date">18/12/2024</span>
                    </div>
                </div>
                <div class="notification-card__content">
                    <p class="notification-description">
                        Phạm vi QMS chưa được mô tả đầy đủ. Thiếu thông tin về các quy trình ngoại vi và ranh giới ứng dụng.
                    </p>
                    <div class="notification-actions">
                        <button class="btn btn-sm btn-outline">Chi tiết</button>
                        <button class="btn btn-sm btn-primary" data-modal-target="response-modal" data-notification="NC-2024-002">
                            Phản hồi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Management Section -->
    <div class="section">
        <div class="section__header">
            <h3 class="section__title">Quản lý hành động khắc phục</h3>
            <div class="section__filters">
                <select class="form-select form-select--compact">
                    <option value="">Tất cả trạng thái</option>
                    <option value="pending">Đang xử lý</option>
                    <option value="completed">Hoàn thành</option>
                    <option value="overdue">Quá hạn</option>
                </select>
                <select class="form-select form-select--compact">
                    <option value="">Tất cả bộ phận</option>
                    <option value="phong-khcn">Phòng KHCN</option>
                    <option value="phong-qlcl">Phòng QLCL</option>
                    <option value="phong-ky-thuat">Phòng Kỹ thuật</option>
                </select>
            </div>
        </div>

        <div class="action-table-container">
            <table class="action-table">
                <thead>
                    <tr>
                        <th>Mã số</th>
                        <th>Phát hiện</th>
                        <th>Nguyên nhân gốc rễ</th>
                        <th>Kế hoạch khắc phục</th>
                        <th>Người chịu trách nhiệm</th>
                        <th>Thời hạn</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="action-row" data-status="overdue">
                        <td class="code-cell">
                            <span class="action-code">CA-2024-001</span>
                        </td>
                        <td class="finding-cell">
                            <div class="finding-text">Chưa có quy trình quản lý rủi ro hệ thống</div>
                            <div class="finding-criteria">Tiêu chí: 6.1 - Hành động ứng phó rủi ro</div>
                        </td>
                        <td class="root-cause-cell">
                            <div class="root-cause">Thiếu nhận thức về tầm quan trọng của quản lý rủi ro. Chưa có đào tạo chuyên sâu về phương pháp đánh giá rủi ro.</div>
                        </td>
                        <td class="plan-cell">
                            <div class="plan-text">1. Xây dựng quy trình quản lý rủi ro<br>2. Đào tạo nhân viên<br>3. Thực hiện đánh giá rủi ro cho tất cả quy trình</div>
                        </td>
                        <td class="responsible-cell">
                            <div class="responsible-person">Nguyễn Văn A</div>
                            <div class="responsible-department">Phòng QLCL</div>
                        </td>
                        <td class="deadline-cell">
                            <div class="deadline-date">20/12/2024</div>
                            <div class="deadline-status deadline-status--overdue">Quá hạn 3 ngày</div>
                        </td>
                        <td class="status-cell">
                            <span class="status-badge status-badge--overdue">Quá hạn</span>
                        </td>
                        <td class="actions-cell">
                            <button class="btn-action btn-action--view" title="Xem chi tiết">👁️</button>
                            <button class="btn-action btn-action--edit" title="Chỉnh sửa" data-modal-target="edit-action-modal" data-action="CA-2024-001">✏️</button>
                            <button class="btn-action btn-action--urgent" title="Nhắc nhở">🚨</button>
                        </td>
                    </tr>

                    <tr class="action-row" data-status="pending">
                        <td class="code-cell">
                            <span class="action-code">CA-2024-002</span>
                        </td>
                        <td class="finding-cell">
                            <div class="finding-text">Phạm vi QMS chưa được mô tả đầy đủ</div>
                            <div class="finding-criteria">Tiêu chí: 4.3 - Phạm vi QMS</div>
                        </td>
                        <td class="root-cause-cell">
                            <div class="root-cause">Thiếu sự phối hợp giữa các bộ phận. Chưa có template chuẩn để mô tả phạm vi QMS.</div>
                        </td>
                        <td class="plan-cell">
                            <div class="plan-text">1. Thu thập thông tin từ tất cả bộ phận<br>2. Xây dựng mô tả phạm vi QMS chi tiết<br>3. Xem xét và phê duyệt</div>
                        </td>
                        <td class="responsible-cell">
                            <div class="responsible-person">Trần Thị B</div>
                            <div class="responsible-department">Phòng KHCN</div>
                        </td>
                        <td class="deadline-cell">
                            <div class="deadline-date">15/01/2025</div>
                            <div class="deadline-status deadline-status--normal">Còn 22 ngày</div>
                        </td>
                        <td class="status-cell">
                            <span class="status-badge status-badge--pending">Đang xử lý</span>
                        </td>
                        <td class="actions-cell">
                            <button class="btn-action btn-action--view" title="Xem chi tiết">👁️</button>
                            <button class="btn-action btn-action--edit" title="Chỉnh sửa" data-modal-target="edit-action-modal" data-action="CA-2024-002">✏️</button>
                            <button class="btn-action btn-action--track" title="Theo dõi">📊</button>
                        </td>
                    </tr>

                    <tr class="action-row" data-status="completed">
                        <td class="code-cell">
                            <span class="action-code">CA-2024-003</span>
                        </td>
                        <td class="finding-cell">
                            <div class="finding-text">Chính sách chất lượng cần cập nhật</div>
                            <div class="finding-criteria">Tiêu chí: 5.2 - Chính sách chất lượng</div>
                        </td>
                        <td class="root-cause-cell">
                            <div class="root-cause">Chính sách hiện tại không phản ánh đầy đủ cam kết của ban lãnh đạo đối với cải tiến liên tục.</div>
                        </td>
                        <td class="plan-cell">
                            <div class="plan-text">1. Xem xét chính sách hiện tại<br>2. Cập nhật nội dung<br>3. Phê duyệt và triển khai</div>
                        </td>
                        <td class="responsible-cell">
                            <div class="responsible-person">Lê Văn C</div>
                            <div class="responsible-department">Ban Giám đốc</div>
                        </td>
                        <td class="deadline-cell">
                            <div class="deadline-date">30/11/2024</div>
                            <div class="deadline-status deadline-status--completed">Hoàn thành</div>
                        </td>
                        <td class="status-cell">
                            <span class="status-badge status-badge--completed">Hoàn thành</span>
                        </td>
                        <td class="actions-cell">
                            <button class="btn-action btn-action--view" title="Xem chi tiết">👁️</button>
                            <button class="btn-action btn-action--verify" title="Xác minh">✅</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-pagination">
            <div class="pagination-info">
                Hiển thị 1-3 của 12 hành động
            </div>
            <div class="pagination-controls">
                <button class="pagination-btn pagination-btn--disabled">‹ Trước</button>
                <button class="pagination-btn pagination-btn--active">1</button>
                <button class="pagination-btn">2</button>
                <button class="pagination-btn">3</button>
                <button class="pagination-btn">Sau ›</button>
            </div>
        </div>
    </div>

    <!-- Statistics Dashboard -->
    <div class="section">
        <div class="section__header">
            <h3 class="section__title">Thống kê hành động khắc phục</h3>
        </div>

        <div class="statistics-dashboard">
            <div class="stats-grid">
                <div class="stats-card stats-card--summary">
                    <div class="stats-card__header">
                        <h4 class="stats-card__title">Tổng quan</h4>
                    </div>
                    <div class="stats-card__content">
                        <div class="summary-stats">
                            <div class="summary-stat">
                                <span class="summary-stat__value">24</span>
                                <span class="summary-stat__label">Tổng số</span>
                            </div>
                            <div class="summary-stat summary-stat--completed">
                                <span class="summary-stat__value">18</span>
                                <span class="summary-stat__label">Hoàn thành</span>
                            </div>
                            <div class="summary-stat summary-stat--pending">
                                <span class="summary-stat__value">4</span>
                                <span class="summary-stat__label">Đang xử lý</span>
                            </div>
                            <div class="summary-stat summary-stat--overdue">
                                <span class="summary-stat__value">2</span>
                                <span class="summary-stat__label">Quá hạn</span>
                            </div>
                        </div>
                        <div class="completion-rate">
                            <div class="completion-bar">
                                <div class="completion-fill" style="width: 75%"></div>
                            </div>
                            <span class="completion-text">75% Hoàn thành</span>
                        </div>
                    </div>
                </div>

                <div class="stats-card">
                    <div class="stats-card__header">
                        <h4 class="stats-card__title">Theo bộ phận</h4>
                    </div>
                    <div class="stats-card__content">
                        <div class="department-stats">
                            <div class="department-stat">
                                <span class="department-name">Phòng QLCL</span>
                                <span class="department-count">8 hành động</span>
                            </div>
                            <div class="department-stat">
                                <span class="department-name">Phòng KHCN</span>
                                <span class="department-count">6 hành động</span>
                            </div>
                            <div class="department-stat">
                                <span class="department-name">Phòng Kỹ thuật</span>
                                <span class="department-count">5 hành động</span>
                            </div>
                            <div class="department-stat">
                                <span class="department-name">Khác</span>
                                <span class="department-count">5 hành động</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Response Modal for Notifications -->
<div id="response-modal" class="modal">
    <div class="modal-backdrop" data-modal-close="response-modal"></div>
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Phản hồi thông báo khắc phục</h3>
            <button type="button" class="modal-close" data-modal-close="response-modal">
                <span>&times;</span>
            </button>
        </div>

        <div class="action-modal-body">
            <form method="POST" action="#" class="audit-form-modal" id="response-form">
                @csrf
                <input type="hidden" id="notification_id" name="notification_id">

                <div class="form-section">
                    <h4 class="form-section__title">Thông tin phát hiện</h4>
                    <div class="notification-preview">
                        <div class="preview-item">
                            <span class="preview-label">Mã số:</span>
                            <span class="preview-value" id="preview-code">NC-2024-003</span>
                        </div>
                        <div class="preview-item">
                            <span class="preview-label">Phát hiện:</span>
                            <span class="preview-value" id="preview-finding">Chưa có quy trình quản lý rủi ro...</span>
                        </div>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group form-group--full">
                        <label for="root_cause" class="form-label">Nguyên nhân gốc rễ (Root cause) *</label>
                        <textarea id="root_cause" name="root_cause" rows="4" class="form-textarea"
                                  placeholder="Phân tích và mô tả nguyên nhân gốc rễ dẫn đến điểm không phù hợp..." required></textarea>
                    </div>

                    <div class="form-group form-group--full">
                        <label for="corrective_plan" class="form-label">Kế hoạch khắc phục *</label>
                        <textarea id="corrective_plan" name="corrective_plan" rows="5" class="form-textarea"
                                  placeholder="Mô tả chi tiết các bước thực hiện để khắc phục:&#10;1. Bước 1...&#10;2. Bước 2...&#10;3. Bước 3..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="responsible_person" class="form-label">Người chịu trách nhiệm *</label>
                        <select id="responsible_person" name="responsible_person" class="form-select" required>
                            <option value="">Chọn người chịu trách nhiệm</option>
                            <option value="nguyen-van-a">Nguyễn Văn A - Phòng QLCL</option>
                            <option value="tran-thi-b">Trần Thị B - Phòng KHCN</option>
                            <option value="le-van-c">Lê Văn C - Phòng Kỹ thuật</option>
                            <option value="pham-van-d">Phạm Văn D - Phòng Tài chính</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="completion_deadline" class="form-label">Thời hạn hoàn thành *</label>
                        <input type="date" id="completion_deadline" name="completion_deadline" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Trạng thái *</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="pending">Đang xử lý</option>
                            <option value="completed">Hoàn thành</option>
                            <option value="overdue">Quá hạn</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="priority" class="form-label">Mức độ ưu tiên</label>
                        <select id="priority" name="priority" class="form-select">
                            <option value="low">Thấp</option>
                            <option value="medium" selected>Trung bình</option>
                            <option value="high">Cao</option>
                            <option value="critical">Khẩn cấp</option>
                        </select>
                    </div>

                    <div class="form-group form-group--full">
                        <label for="additional_notes" class="form-label">Ghi chú bổ sung</label>
                        <textarea id="additional_notes" name="additional_notes" rows="3" class="form-textarea"
                                  placeholder="Thông tin bổ sung, tài nguyên cần thiết, hoặc lưu ý đặc biệt..."></textarea>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-outline" data-modal-close="response-modal">Hủy bỏ</button>
            <button type="submit" form="response-form" class="btn btn-primary">
                <span class="btn-icon">💾</span>
                Lưu hành động khắc phục
            </button>
        </div>
    </div>
</div>

<!-- Create Action Modal -->
<div id="create-action-modal" class="program-modal">
    <div class="program-modal-backdrop" data-modal-close="create-action-modal"></div>
    <div class="program-modal-container">
        <div class="program-modal-header">
            <h3 class="program-modal-title">Tạo hành động khắc phục mới</h3>
            <button type="button" class="program-modal-close" data-modal-close="create-action-modal">
                <span>&times;</span>
            </button>
        </div>

        <div class="program-modal-body">
            <form method="POST" action="#" class="audit-form-modal" id="create-action-form">
                @csrf
                <div class="form-grid">
                    <div class="form-group form-group--full">
                        <label for="finding_description" class="form-label">Mô tả phát hiện *</label>
                        <textarea id="finding_description" name="finding_description" rows="3" class="form-textarea"
                                  placeholder="Mô tả chi tiết điểm không phù hợp hoặc cơ hội cải tiến..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="criteria_reference" class="form-label">Tiêu chí tham chiếu</label>
                        <input type="text" id="criteria_reference" name="criteria_reference" class="form-input"
                               placeholder="Ví dụ: 4.3 - Phạm vi QMS">
                    </div>

                    <div class="form-group">
                        <label for="department" class="form-label">Bộ phận liên quan *</label>
                        <select id="department" name="department" class="form-select" required>
                            <option value="">Chọn bộ phận</option>
                            <option value="phong-ky-thuat">Phòng Kỹ thuật</option>
                            <option value="phong-khcn">Phòng KHCN</option>
                            <option value="phong-tai-chinh">Phòng Tài chính</option>
                            <option value="phong-nhan-su">Phòng Nhân sự</option>
                            <option value="phong-an-toan">Phòng An toàn</option>
                            <option value="phong-qlcl">Phòng QLCL</option>
                            <option value="ban-giam-doc">Ban Giám đốc</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="action_type" class="form-label">Loại hành động *</label>
                        <select id="action_type" name="action_type" class="form-select" required>
                            <option value="">Chọn loại hành động</option>
                            <option value="corrective">Khắc phục (Corrective Action)</option>
                            <option value="preventive">Phòng ngừa (Preventive Action)</option>
                            <option value="improvement">Cải tiến (Improvement)</option>
                        </select>
                    </div>

                    <div class="form-group form-group--full">
                        <label for="new_root_cause" class="form-label">Nguyên nhân gốc rễ (Root cause) *</label>
                        <textarea id="new_root_cause" name="root_cause" rows="4" class="form-textarea"
                                  placeholder="Phân tích và mô tả nguyên nhân gốc rễ dẫn đến vấn đề..." required></textarea>
                    </div>

                    <div class="form-group form-group--full">
                        <label for="new_corrective_plan" class="form-label">Kế hoạch khắc phục *</label>
                        <textarea id="new_corrective_plan" name="corrective_plan" rows="5" class="form-textarea"
                                  placeholder="Mô tả chi tiết các bước thực hiện để khắc phục:&#10;1. Bước 1...&#10;2. Bước 2...&#10;3. Bước 3..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="new_responsible_person" class="form-label">Người chịu trách nhiệm *</label>
                        <select id="new_responsible_person" name="responsible_person" class="form-select" required>
                            <option value="">Chọn người chịu trách nhiệm</option>
                            <option value="nguyen-van-a">Nguyễn Văn A</option>
                            <option value="tran-thi-b">Trần Thị B</option>
                            <option value="le-van-c">Lê Văn C</option>
                            <option value="pham-van-d">Phạm Văn D</option>
                            <option value="hoang-thi-e">Hoàng Thị E</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="new_completion_deadline" class="form-label">Thời hạn hoàn thành *</label>
                        <input type="date" id="new_completion_deadline" name="completion_deadline" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="priority_level" class="form-label">Mức độ ưu tiên</label>
                        <select id="priority_level" name="priority_level" class="form-select">
                            <option value="low">Thấp</option>
                            <option value="medium" selected>Trung bình</option>
                            <option value="high">Cao</option>
                            <option value="critical">Khẩn cấp</option>
                        </select>
                    </div>

                    <div class="form-group form-group--full">
                        <label for="resources_needed" class="form-label">Tài nguyên cần thiết</label>
                        <textarea id="resources_needed" name="resources_needed" rows="2" class="form-textarea"
                                  placeholder="Mô tả tài nguyên, nguồn lực cần thiết để thực hiện hành động..."></textarea>
                    </div>

                    <div class="form-group form-group--full">
                        <label for="action_notes" class="form-label">Ghi chú</label>
                        <textarea id="action_notes" name="action_notes" rows="2" class="form-textarea"
                                  placeholder="Ghi chú bổ sung"></textarea>
                    </div>
                </div>
            </form>
        </div>

        <div class="program-modal-footer">
            <button type="button" class="btn btn-outline" data-modal-close="create-action-modal">Hủy bỏ</button>
            <button type="submit" form="create-action-form" class="btn btn-primary">
                <span class="btn-icon">📋</span>
                Tạo hành động khắc phục
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal functionality
    document.querySelectorAll('[data-modal-target]').forEach(trigger => {
        trigger.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);

            if (modal) {
                // Check if it's program-modal or regular modal
                if (modal.classList.contains('program-modal')) {
                    modal.classList.add('program-modal--active');
                } else {
                    modal.classList.add('modal--active');
                }
                document.body.style.overflow = 'hidden';

                // Handle notification response modal
                if (modalId === 'response-modal') {
                    const notificationCode = this.getAttribute('data-notification');
                    if (notificationCode) {
                        document.getElementById('notification_id').value = notificationCode;
                        document.getElementById('preview-code').textContent = notificationCode;

                        // Update preview finding based on notification
                        const notificationMap = {
                            'NC-2024-003': 'Chưa có quy trình quản lý rủi ro và cơ hội một cách hệ thống',
                            'NC-2024-002': 'Phạm vi QMS chưa được mô tả đầy đủ'
                        };

                        document.getElementById('preview-finding').textContent =
                            notificationMap[notificationCode] || 'Không xác định';
                    }
                }
            }
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach(closeBtn => {
        closeBtn.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-close');
            const modal = document.getElementById(modalId);
            if (modal) {
                // Check if it's program-modal or regular modal
                if (modal.classList.contains('program-modal')) {
                    modal.classList.remove('program-modal--active');
                } else {
                    modal.classList.remove('modal--active');
                }
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
            const activeModal = document.querySelector('.modal.modal--active, .program-modal.program-modal--active');
            if (activeModal) {
                if (activeModal.classList.contains('program-modal')) {
                    activeModal.classList.remove('program-modal--active');
                } else {
                    activeModal.classList.remove('modal--active');
                }
                document.body.style.overflow = '';
            }
        }
    });

    // Form submissions
    document.getElementById('response-form').addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('Submitting response form');
        // Implement form submission logic
    });

    document.getElementById('create-action-form').addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('Submitting create action form');
        // Implement form submission logic
    });

    // Action button handlers
    document.querySelectorAll('.btn-action').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.className.split(' ').find(cls => cls.includes('--')).split('--')[1];
            console.log(`Action: ${action}`);
            // Implement action functionality here
        });
    });

    // Table filtering
    document.querySelectorAll('.form-select').forEach(select => {
        select.addEventListener('change', function() {
            console.log('Filter changed:', this.value);
            // Implement filtering logic
        });
    });

    // Set minimum date for deadline inputs to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('completion_deadline').setAttribute('min', today);
    document.getElementById('new_completion_deadline').setAttribute('min', today);
});
</script>
@endsection