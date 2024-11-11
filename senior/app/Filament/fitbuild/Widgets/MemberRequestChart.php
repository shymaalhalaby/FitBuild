<?php

namespace App\Filament\Fitbuild\Widgets;

use Filament\Widgets\ChartWidget;

class MemberRequestChart extends ChartWidget
{
    protected static ?string $heading = 'Member Request';

    protected static string $color = 'info';





    protected function getData(): array
    {

        return [

           'datasets' => [
                [
                    'label' => 'Member Requests recieved !',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];

    }

    protected function getType(): string
    {
        return 'bar';
    }

}
