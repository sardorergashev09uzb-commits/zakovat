<?php

declare(strict_types=1);

namespace backend\widgets;

use Yii;
use yii\base\Widget;

/**
 * AdminHeader widgeti admin paneldagi sarlavha qismini chiqarish uchun xizmat qiladi.
 */
class AdminHeader extends Widget
{
    /**
     * @var string Sarlavha matni
     */
    public string $title = 'Boshqaruv paneli';

    /**
     * @var string|null Sana (agar berilmasa bugungi sana avtomatik olinadi)
     */
    public ?string $date = null;

    /**
     * @var string|null Qo'shimcha tavsif yoki matn
     */
    public ?string $subtitle = null;

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        if ($this->date === null) {
            $this->date = date('d.m.Y');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run(): string
    {
        return $this->render('admin-header', [
            'title' => $this->title,
            'date' => $this->date,
            'subtitle' => $this->subtitle,
        ]);
    }
}
