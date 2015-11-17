<?php

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel \app\models\CardSearch */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\jui\DatePicker;
use app\models\Card;
use app\models\Serial;

$this->title = 'Карты';
$this->params['breadcrumbs'][] = '';

$js=<<<JS
$('.card-delete').on('click', function(event){
    event.preventDefault();
    var self = $(this);
    $.post('/card/delete', {id:self.data('id')})
        .done(function(data){
            if (data.result==true) {
                self.parents('tr').remove();
            }
        });
});
JS;
$this->registerJs($js);
?>

<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'layout' => '{items}{pager}',
    'columns' => [
        'id',
        [
            'attribute' => 'serialSerial',
            'value' => 'serial.serial',
        ],
        'number',
        [
            'attribute' => 'serialReleaseDate',
            'value' => 'serial.release_date',
            'filter' => DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'serialReleaseDate',
                'options' => ['class' => 'form-control'],
                'dateFormat' => 'yyyy-MM-dd',
            ])
        ],
//        [
//            'attribute' => 'begin_date',
//            'filter' => DatePicker::widget([
//                'model' => $searchModel,
//                'attribute' => 'begin_date',
//                'options' => ['class' => 'form-control'],
//                'dateFormat' => 'yyyy-MM-dd',
//            ])
//        ],
        [
            'attribute' => 'end_date',
            'filter' => DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'end_date',
                'options' => ['class' => 'form-control'],
                'dateFormat' => 'yyyy-MM-dd',
            ])
        ],
//        [
//            'attribute' => 'serialDuration',
//            'format' => 'raw',
//            'value' => 'serial.durationText',
//            'filter' => Html::activeDropDownList($searchModel, 'serialDuration', Serial::getDurations(), [
//                'class'=>'form-control',
//                'prompt' => ''
//            ]),
//            'label' => 'Срок активности',
//        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function($data){
                return Html::a($data->statusText,['/card/update', 'id' => $data->id], ['class' => 'book-view']);
            },
            'filter' => Html::activeDropDownList($searchModel, 'status', Card::getStatuses(), [
                'class'=>'form-control',
                'prompt' => ''
            ]),
        ],
        [
            'class' => \yii\grid\ActionColumn::class,
            'header'=>'Действия',
            'headerOptions' => ['width' => '150'],
            'template' => '{view} {delete}',
            'buttons' => [
                'delete' => function ($url, $model) {
                    return Html::a('Удалить', null, ['class' => 'card-delete', 'data-id'=>$model->id]);
                },
                'view' => function ($url, $model) {
                    return Html::a('Просмотр',$url, ['class' => 'book-view']);
                },
            ],
        ],
    ],
]);