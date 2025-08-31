<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_id',
        'level2_user_id',
        'title',
        'proposal_type',
        'priority',
        'description',
        'proposed_content',
        'reason',
        'status',
        'response',
        'responded_by',
        'responded_at'
    ];

    protected $casts = [
        'responded_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    public function level2User()
    {
        return $this->belongsTo(User::class, 'level2_user_id');
    }

    public function getProposalTypeName()
    {
        $types = [
            'content_correction' => 'Sửa nội dung',
            'format_improvement' => 'Cải thiện định dạng',
            'additional_info' => 'Bổ sung thông tin',
            'process_optimization' => 'Tối ưu quy trình',
            'other' => 'Khác'
        ];

        return $types[$this->proposal_type] ?? 'Không xác định';
    }

    public function getPriorityName()
    {
        $priorities = [
            'low' => 'Thấp',
            'medium' => 'Trung bình',
            'high' => 'Cao',
            'urgent' => 'Khẩn cấp'
        ];

        return $priorities[$this->priority] ?? 'Không xác định';
    }

    public function getStatusName()
    {
        $statuses = [
            'pending' => 'Chờ xử lý',
            'approved' => 'Chấp nhận',
            'rejected' => 'Từ chối',
            'implemented' => 'Đã thực hiện'
        ];

        return $statuses[$this->status] ?? 'Không xác định';
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeImplemented($query)
    {
        return $query->where('status', 'implemented');
    }
}