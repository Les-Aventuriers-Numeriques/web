<?php

namespace App\View\Components;

use App\Enums\AlertType;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\View\Component;

class Alert extends Component
{
    public ?string $type;

    public ?string $message;

    public function __construct()
    {
        $this->type = Arr::first(AlertType::values(), fn (string $type): bool => session()->has($type));
        $this->message = $this->type ? session()->get($this->type) : null;
    }

    public function render(): View
    {
        return view('components.alert');
    }

    public function shouldRender(): bool
    {
        return $this->type && $this->message;
    }
}
