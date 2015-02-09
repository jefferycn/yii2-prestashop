<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
// use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Customer;

class SiteController extends Controller
{

    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        \ControllerFactory::getController('IndexController')->run();
        return "";
    }

    public function actionCatalog()
    {
        \ControllerFactory::getController('CategoryController')->run();
        return "";
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        \ControllerFactory::getController('AuthController')->run();
    }

    public function beforeAction($action)
    {
        if (\Yii::$app->request->get("mylogout") === "") {
            \Yii::$app->user->logout();
        }

        // register prestashop cookie
        \ControllerFactory::getController('IndexController');
        global $cookie;
        if (\Yii::$app->user->isGuest && $cookie->logged) {
            $user = Customer::findOne($cookie->id_customer);
            \Yii::$app->user->login($user);
        }

        return true;
    }

    // public function actionLogout()
    // {
    //     Yii::$app->user->logout();

    //     \ControllerFactory::getController('IndexController')->run();
    // }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
