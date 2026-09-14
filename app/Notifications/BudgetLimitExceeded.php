<?php

namespace App\Notifications;

use App\Models\Budget;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BudgetLimitExceeded extends Notification
{
    use Queueable;

    protected Budget $budget;
    protected float $spent;

    public function __construct(Budget $budget, float $spent)
    {
        $this->budget = $budget;
        $this->spent = $spent;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $categoryName = $this->budget->category->name ?? 'kategori ini';
        $percentage = $this->budget->monthly_limit > 0
            ? round(($this->spent / $this->budget->monthly_limit) * 100, 1)
            : 0;

        return (new MailMessage)
            ->subject('⚠️ Amaran: Budget "' . $categoryName . '" Telah Melebihi Had')
            ->greeting('Hai ' . $notifiable->name . ',')
            ->line('Perbelanjaan ko untuk kategori **' . $categoryName . '** bulan ni dah melebihi had budget yang ditetapkan.')
            ->line('Had Budget: RM ' . number_format($this->budget->monthly_limit, 2))
            ->line('Jumlah Dibelanjakan: RM ' . number_format($this->spent, 2) . ' (' . $percentage . '%)')
            ->action('Lihat Budget', route('budgets.index'))
            ->line('Cuba semak semula perbelanjaan ko untuk kategori ni supaya tak terus melebihi had.')
            ->salutation('Salam jimat cermat, Duitku 💰');
    }
}