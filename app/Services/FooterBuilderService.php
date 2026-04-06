<?php

namespace App\Services;

class FooterBuilderService
{
    public function defaultSections(): array
    {
        return [
            [
                'type' => 'quick_links',
                'title' => 'دسترسی سریع',
                'enabled' => true,
                'sort_order' => 1,
            ],
            [
                'type' => 'company_intro',
                'title' => 'معرفی آریا',
                'enabled' => true,
                'sort_order' => 2,
            ],
            [
                'type' => 'contact_social',
                'title' => 'اطلاعات تماس و شبکه‌های اجتماعی',
                'enabled' => true,
                'sort_order' => 3,
            ],
            [
                'type' => 'trust_badge',
                'title' => 'نماد اعتماد',
                'enabled' => true,
                'sort_order' => 4,
            ],
        ];
    }

    public function defaultQuickLinks(): array
    {
        return [
            ['label' => 'صفحه اصلی', 'url' => '/', 'enabled' => true, 'sort_order' => 1],
            ['label' => 'فروشگاه', 'url' => '/products', 'enabled' => true, 'sort_order' => 2],
            ['label' => 'تماس با ما', 'url' => '/contact', 'enabled' => true, 'sort_order' => 3],
            ['label' => 'وبلاگ', 'url' => '/posts', 'enabled' => false, 'sort_order' => 4],
        ];
    }

    public function defaultContactData(): array
    {
        return [
            'address' => option('info_address'),
            'phone' => option('info_tel'),
            'email' => option('info_email'),

            'show_address' => true,
            'show_phone' => true,
            'show_email' => true,

            'instagram' => option('social_instagram'),
            'telegram' => option('social_telegram'),
            'whatsapp' => option('social_whatsapp'),

            'show_instagram' => true,
            'show_telegram' => true,
            'show_whatsapp' => true,

            'show_trust_badge' => true,
            'trust_badge_image' => '',
            'trust_badge_url' => '',
        ];
    }

    public function getSections(): array
    {
        $sections = $this->decodeJsonOption('footer_sections', $this->defaultSections());

        return collect($sections)
            ->map(function ($section) {
                return [
                    'type' => $section['type'] ?? 'quick_links',
                    'title' => $section['title'] ?? '',
                    'enabled' => (bool) ($section['enabled'] ?? true),
                    'sort_order' => (int) ($section['sort_order'] ?? 0),
                ];
            })
            ->sortBy('sort_order')
            ->values()
            ->all();
    }

    public function getQuickLinks(): array
    {
        $links = $this->decodeJsonOption('footer_quick_links', $this->defaultQuickLinks());

        return collect($links)
            ->map(function ($item) {
                return [
                    'label' => $item['label'] ?? '',
                    'url' => $item['url'] ?? '',
                    'enabled' => (bool) ($item['enabled'] ?? true),
                    'sort_order' => (int) ($item['sort_order'] ?? 0),
                ];
            })
            ->sortBy('sort_order')
            ->values()
            ->all();
    }

    public function getContactData(): array
    {
        return array_merge($this->defaultContactData(), $this->decodeJsonOption('footer_contact_data', []));
    }

    private function decodeJsonOption(string $key, array $default): array
    {
        $raw = option($key);

        if (!$raw) {
            return $default;
        }

        if (is_array($raw)) {
            return $raw;
        }

        $decoded = json_decode($raw, true);

        return is_array($decoded) ? $decoded : $default;
    }
}
