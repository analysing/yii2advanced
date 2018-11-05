<?php

namespace api\models;

use Yii;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%member}}".
 *
 * @property string $id
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $secure_pwd 安全密码
 * @property int $level 等级，100会员，0总代，1:1代，2:2代
 * @property int $status 状态，10正常,0删除
 * @property string $name 昵称
 * @property int $gender 性别，0未知，1男，2女
 * @property string $birth 出生日期
 * @property string $phone 手机号
 * @property string $mobile 电话
 * @property string $qq QQ
 * @property string $wechat 微信号
 * @property string $email 邮箱
 * @property string $address 地址
 * @property string $realname 真实姓名
 * @property string $bank_account 银行账号
 * @property string $profile 简介
 * @property string $remark 备注
 * @property int $first_login_time 首次登录时间
 * @property int $first_login_ip 首次登录IP
 * @property int $reg_device 注册设备,0后台添加
 * @property int $created 创建时间
 * @property int $creater 创建人
 */
class Member extends \yii\db\ActiveRecord implements Linkable
{
    public $aa = 'apple';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%member}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'first_login_time', 'first_login_ip'], 'required'],
            [['level', 'status', 'gender', 'first_login_time', 'first_login_ip', 'reg_device', 'created', 'creater'], 'integer'],
            [['birth'], 'safe'],
            [['username', 'name', 'realname'], 'string', 'max' => 20],
            [['password', 'secure_pwd', 'address', 'profile', 'remark'], 'string', 'max' => 255],
            [['phone', 'mobile', 'qq', 'wechat'], 'string', 'max' => 15],
            [['email', 'bank_account'], 'string', 'max' => 30],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', '用户名'),
            'password' => Yii::t('app', '密码'),
            'secure_pwd' => Yii::t('app', '安全密码'),
            'level' => Yii::t('app', '等级，100会员，0总代，1:1代，2:2代'),
            'status' => Yii::t('app', '状态，10正常,0删除'),
            'name' => Yii::t('app', '昵称'),
            'gender' => Yii::t('app', '性别，0未知，1男，2女'),
            'birth' => Yii::t('app', '出生日期'),
            'phone' => Yii::t('app', '手机号'),
            'mobile' => Yii::t('app', '电话'),
            'qq' => Yii::t('app', 'QQ'),
            'wechat' => Yii::t('app', '微信号'),
            'email' => Yii::t('app', '邮箱'),
            'address' => Yii::t('app', '地址'),
            'realname' => Yii::t('app', '真实姓名'),
            'bank_account' => Yii::t('app', '银行账号'),
            'profile' => Yii::t('app', '简介'),
            'remark' => Yii::t('app', '备注'),
            'first_login_time' => Yii::t('app', '首次登录时间'),
            'first_login_ip' => Yii::t('app', '首次登录IP'),
            'reg_device' => Yii::t('app', '注册设备,0后台添加'),
            'created' => Yii::t('app', '创建时间'),
            'creater' => Yii::t('app', '创建人'),
        ];
    }

    public function fields()
    {
        return [
            'username',
            'level',
            'name',
            'gender',
            'birth',
            'phone',
            'qq',
            'wx' => 'wechat',
            'profile' => function ($model) {
                return $model->profile ? json_decode($model->profile, true) : 'hello world';
            },
            'remark',
            'aa',
            'bb' => function ($model) {
                return 'banana';
            }
        ];
    }

    public function extraFields()
    {
        return [
            'cc' => function () {
                return 'cat';
            }
        ];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['member/view', 'id' => $this->id], true),
            'index' => Url::to(['member/index'], true),
            'edit' => Url::to(['member/view', 'id' => $this->id], true),
        ];
    }
}
