<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings, WithChunkReading
{
    public function __construct(public $filters) {}

    public function collection()
    {
        info("herekdnaklsdhfafsiashfoia---1111");

        return Product::ordered()
            ->when(@$this->filters['categoryId'], function ($query, $categoryId) {
                return $query->whereHas('category', function ($q) use ($categoryId) {
                    $q->whereKey($categoryId);
                });
            })
            ->when(@$this->filters['search'], function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('tags', 'like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%');
                });
            })
            ->when(@$this->filters['price'], function ($query, $price) {
                return $query->where('price', 'like', '%' . $price . '%');
            })
            ->when(@$this->filters['name'], function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when(@$this->filters['description'], function ($query, $description) {
                return $query->where('description', 'like', '%' . $description . '%');
            })
            ->when(@$this->filters['tags'], function ($query, $tags) {
                return $query->where('tags', 'like', '%' . $tags . '%');
            })
            ->when(@$this->filters['code'], function ($query, $code) {
                return $query->where('code', $code);
            })
            ->when(@$this->filters['active'] !== null, function ($query, $active) {
                return $query->where('active', $active);
            })->select('id', 'code', 'name', 'description', 'price', 'active', 'tags')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Code',
            'Name',
            'Description',
            'Price',
            'Active',
            'Tags',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
