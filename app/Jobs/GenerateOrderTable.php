<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class GenerateOrderTable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $order_products, protected $orderid, protected $priceType)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $i = 1;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        foreach ($this->order_products as $order_product) {
            $sheet->setCellValue('C'.$i,$order_product->product->article);
            $sheet->setCellValue('D'.$i,$order_product->product->name);
            $sheet->setCellValue('F'.$i,$order_product->count);
            $sheet->setCellValue('G'.$i,$order_product->product->getPriceByType($this->priceType));
            $i++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/public/tmp/report').$this->orderid.'.xlsx');
    }
}
