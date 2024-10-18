<?php

namespace Blueprint\Models\Statements;

class RenderStatement
{
    // Corresponds to either Blade view (ex. 'users.index') or Inertia page (ex. 'User/Index')
    private string $view;

    private array $data;

    public function __construct(string $view, array $data = [])
    {
        $this->view = $view;
        $this->data = $data;
    }

    public function view(): string
    {
        return $this->view;
    }

    public function data(): array
    {
        return $this->data;
    }

    public function output(): string
    {
        // TODO: Change $this->view() from ex. 'audits.index' to 'Audit/Index'
        $code = "return Inertia::render('" . $this->view() . "'";

        if ($this->data()) {
            // TODO: Fix for multiple parameters - only currently works for one
            $params = $this->buildParameters($this->data());
            $code .= ", ['" . $params . "' => $" . $params . "]";
        }

        $code .= ');';

        return $code;
    }

    private function buildParameters(array $data): string
    {
        return implode(', ', $data);
    }
}
