<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Заполняемые поля
    protected $fillable = ['user_id', 'rating', 'comment', 'user_avatar', 'is_company'];

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Получение URL для аватара
    public function getAvatarUrlAttribute()
    {
        if ($this->user_avatar) {
            return asset($this->user_avatar); // Для аватара, загруженного пользователем
        }

        return $this->user?->avatar
            ? asset($this->user->avatar) // Если аватар есть у пользователя
            : asset('img/reviews/defult-avatar.png'); // Для дефолтного аватара
    }

    // Получение полного имени пользователя (если нужно)
    public function getFullNameAttribute()
    {
        if ($this->user) {
            return $this->user->name . ' ' . $this->user->surname; // Имя и фамилия пользователя
        }
        return 'Неизвестно'; // Для отзывов без привязки к пользователю
    }
}
