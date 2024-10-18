<?php

namespace Blueprint\Models\Statements;

use Illuminate\Support\Str;

class RenderStatement
{
    private string $view;

    private array $data;

    public function __construct(string $view, array $data = [])
    {
        $this->view = $view;
        $this->data = $data;
    }

    public function view(): string
    {
        return $this->generatePageName($this->view);
    }

    public function data(): array
    {
        return $this->data;
    }

    public function output(): string
    {
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
    
    // Generates a page name (ex. Audits/Index) from a view name (ex. audits.index)
    private function generatePageName(string $view)
    {
        [$table, $method] = explode('.', $view);
        
        $page = Str::studly($table) . '/' . Str::studly($method);
        
        return $page;
    }
}
