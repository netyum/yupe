<?php
/**
 * Форма для запроса смены пароля
 *
 * @category YupeComponents
 * @package  yupe.modules.user.forms
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class RecoveryForm extends CFormModel
{
    public $email;
    private $_user = null;

    public function rules()
    {
        return array(
            array('email', 'required'),
            array('email', 'email'),
            array('email', 'checkEmail'),
        );
    }

    public function checkEmail($attribute, $params)
    {
        if ($this->hasErrors() === false) {
            $this->_user = User::model()->with('recovery')->active()->find(
                'email = :email', array(
                    ':email' => $this->$attribute
                )
            );

            if ($this->_user === null) {
                $this->addError(
                    '',
                    Yii::t(
                        'UserModule.user', 'Email "{email}" was not found or user was blocked !', array(
                            '{email}' => $this->email
                        )
                    )
                );
            }
        }
    }

    public function getUser()
    {
        return $this->_user;
    }
}