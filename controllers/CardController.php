<?php

namespace app\controllers;

use app\filters\AjaxAccess;

use app\models\Card;
use app\models\Serial;
use app\models\CardForm;
use Yii;
use yii\web\Controller;
use app\helpers\Strings as StringHelper;

class CardController extends Controller
{
    public function behaviors()
    {
        return [
            // удалять можно только запросами ajax
            'ajax' => [
                'class' => AjaxAccess::class,
                'only'  => ['delete'],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => \yii\web\ErrorAction::class,
        ];
    }

    public function actionIndex()
    {
        $searchModel = new \app\models\CardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        Yii::$app->getUser()->setReturnUrl(Yii::$app->request->getUrl());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionView()
    {
        $id = (int)Yii::$app->request->get('id');
        $card = Card::findOne(['id' => $id]);

        $serial = Serial::findOne(['id' => $card->serial_id]);

        return $this->render('view', [
            'card' => $card,
            'serial' => $serial,
        ]);
    }

    public function actionGenerate()
    {
        $formModel = new \app\models\GeneratorForm();
        if (Yii::$app->request->post()) {
            $formModel->load(Yii::$app->request->post());
            if ($formModel->validate()){

                $formModel->generate();

                $msg = StringHelper::humanPlural($formModel->quantity, [
                    'карта сгенерирована',
                    'карты сгенерировано',
                    'карт сгенерировано'
                ]);
                \Yii::$app->getSession()->setFlash('success', $msg);

                return $this->redirect('/card/index');
            }
        }

        return $this->render('generate', [
            'formModel' => $formModel,
        ]);
    }

    public function actionUpdate()
    {
        $id = (int)Yii::$app->request->get('id');

        if ($id) {
            /** @var Card $card */
            $card = Card::findOne(['id' => $id]);
            if ($card) {
                $formModel = new CardForm();
                $formModel->fill($card);

                if ($formModel->load(Yii::$app->request->post())) {
                    if ($formModel->update($card)) {
                        return $this->goBack();
                    }
                }

                $action = $card->status==Card::STATUS_ACTIVE ? 'Деактивировать' : 'Активировать';

                return $this->render('update', [
                    'formModel' => $formModel,
                    'card' => $card,
                    'action' => $action,
                ]);
            }
        }

        return $this->goBack();
    }

    public function actionDelete()
    {
        $id = (int)Yii::$app->request->post('id');

        /** @var Card $card */
        $card = Card::findOne(['id' => $id]);
        $result = $card
            ? $card->delete()
            : false;

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return ['result' => (bool)$result];
    }
}