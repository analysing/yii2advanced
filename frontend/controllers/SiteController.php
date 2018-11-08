<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
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
                'only' => ['logout', 'signup', 'redis-test'],
                'rules' => [
                    [
                        'actions' => ['signup', 'redis-test'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
     * @return mixed
     */
    public function actionIndex()
    {
        // file_put_contents('d:/1.txt', var_export(Yii::$app->session, 1) . Yii::$app->session->get('username'));
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->set('username', $model->username);
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionRedisTest()
    {
        // String
        $redis = Yii::$app->redis;
        echo $redis->get('name');
        // SortedSet、HyperLogLog、GEO、Pub/Sub、Transaction、Script、Connection、Server
        /*$redis->zadd('names', 0, 'bill'); // 增
        $redis->zadd('names', 4, 'bill'); // 改
        $redis->zadd('names', 1, 'ivy', 2, 'admin', 3, json_encode(['sa', 'root'])); // 增
        $redis->zrem('names', 'bill66'); // 删
        $redis->zrem('names', 'admin', json_encode(['sa', 'root']), 'ii'); // 删，多个
        echo '<pre>';
        // var_dump($redis->zrange('names', 0, 2, 'withscores')); // WITHSCORES
        var_dump($redis->zrange('names', 0, -1, 'withscores')); // 查
        echo '</pre>';*/

        // Set
        /*$redis->sadd('addr', 'guangzhou', 'manila');
        $redis->sadd('addr', 'beijing');
        $this->_debug($redis->smembers('addr'));*/

        // Hash
        /*$redis->hset('language', 'programer1', 'php');
        $redis->hset('language', 'programer2', 'js');
        $redis->hset('language', 'programer3', 'html');
        $redis->hset('language', 4, 'go');
        $redis->hset('language', 5, 'python');
        $this->_debug($redis->hget('language', 4));
        $this->_debug($redis->hvals('language'));
        $this->_debug($redis->hkeys('language'));
        $redis->hmset('db', 1, 'mysql', 2, 'mongodb', 3, 'redis', 4, 'oracle', 5, 'sqlserver', 6, json_encode(['aa', 'bb', 'cc']));
        $redis->hdel('db', 6);
        $this->_debug($redis->hget('db', 6));
        $this->_debug($redis->hmget('db', 1, 2, 3));*/

        // List
        /*$redis->lpush('runoob', 'redis');
        $redis->rpush('runoob', 'mongodb');
        $redis->lpush('runoob', 'mysql');
        $this->_debug($redis->lrange('runoob', 0, -1));*/
    }

    private function _debug($a)
    {
        echo '<pre>';
        var_dump($a);
        echo '</pre>';
    }
}
