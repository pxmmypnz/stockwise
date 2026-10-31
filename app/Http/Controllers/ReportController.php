<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    public function lowStock(): View
    {
        Gate::authorize('viewLowStockReport', Item::class);

        return view('reports.low-stock', [
            'items' => $this->lowStockItems(),
        ]);
    }

    public function lowStockPdf(): Response
    {
        Gate::authorize('viewLowStockReport', Item::class);

        return Pdf::loadView('reports.low-stock-pdf', [
            'items' => $this->lowStockItems(),
            'generatedAt' => now(),
        ])->setPaper('a4')->download('low-stock-report.pdf');
    }

    /**
     * @return Collection<int, Item>
     */
    private function lowStockItems(): Collection
    {
        return Item::with(['category', 'supplier'])
            ->whereColumn('quantity', '<=', 'reorder_level')
            ->orderBy('quantity')
            ->orderBy('name')
            ->get();
    }
}
