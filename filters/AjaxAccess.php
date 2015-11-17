<?php

namespace app\filters;

use Yii;
use yii\base\ActionFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class AjaxAccess extends ActionFilter
{
    /**
     * Declares event handlers for the [[owner]]'s events.
     * @return array events (array keys) and the corresponding event handler methods (array values).
     */
    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    /**
     * @param \yii\base\Action $event
     * @return bool
     * @throws ForbiddenHttpException
     */
    public function beforeAction($event)
    {
        if (Yii::$app->request->isAjax)
            return parent::beforeAction($event);
        else
            throw new ForbiddenHttpException('Only ajax!');
    }
}