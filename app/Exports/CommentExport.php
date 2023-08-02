<?php

namespace App\Exports;

use App\Models\CustomerComment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CommentExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return CustomerComment::with('Customer', 'User')
            ->select('id', 'customers_id', 'user_id', 'date', 'comment')
            ->orderBy('date', 'desc') // Order by 'date' column in descending order (most recent first)
            ->get()
            ->map(function ($comment) {
                return [
                    'Customer Name' => $comment->Customer->customer_name ?? '',
                    'User Name' => $comment->User->name ?? '',
                    'Date' => $comment->date ?? '',
                    'Comment' => $comment->comment ?? '',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Customer Name',
            'User Name',
            'Date',
            'Comment',
        ];
    }
}
