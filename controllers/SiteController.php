<?php

namespace app\controllers;

use app\models\Dish;
use app\models\Ingredient;
use app\models\IngredientsForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new IngredientsForm();
        $ingredients = Ingredient::find()->where("available='1'")->all();
        $ingredients = ArrayHelper::map($ingredients,'id','name');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $dishes = Dish::find()->joinWith('ingredients')->where(['in','ingredients.id', $model->ingredients])->andWhere(['ingredients.available'=>'1'])->all();
            $all = [];
            $part = [];
            $result = [];
            foreach ($dishes as $item) {
                $item->matchIngredients = $item->getIngredients()->where(['in','ingredients.id', $model->ingredients])->all();

                if(count($item->matchIngredients)>=2 && count($item->matchIngredients)==count($model->ingredients)){
                    $all[] = $item;
                }
                elseif(count($item->matchIngredients)>=2){
                    $part[] = $item;
                }
            }
            usort($part, [$this, "cmp"]);
            if(!empty($all) || !empty($part))
                $result = empty($all) ? $part : $all;
            else
                Yii::$app->session->setFlash('error','Ничего не найдено');
        }
        return $this->render('index', compact('ingredients', 'model', 'result'));
    }

    private function cmp($a, $b){
        return strcmp(count($b->matchIngredients), count($a->matchIngredients));
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
