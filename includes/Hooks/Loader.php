<?php

namespace Loglyzer\Hooks;

defined('ABSPATH') || exit;

class Loader
{
    protected array $actions = [];

    public function add_action(string $name, callable $callback): void {
        $this->actions[] = compact('name', 'callback');
    }

    public function run(): void {
        foreach ($this->actions as $action) {
            add_action($action['name'], $action['callback']);
        }
    }
}
