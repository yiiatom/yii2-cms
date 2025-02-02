<?php

namespace atom\cms\forms;

use Yii;
use atom\cms\models\User;
use yii\base\Model;

class UserForm extends Model
{
    public ?bool $active;
    public ?string $username;
    public ?string $email;
    public ?string $firstName;
    public ?string $lastName;
    public array $roles;

    private User $_user;

    public function __construct(User $user)
    {
        $this->_user = $user;

        // Attributes
        $this->active = $user->active;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->firstName = $user->firstName;
        $this->lastName = $user->lastName;

        // Roles
        $auth = Yii::$app->authManager;
        $this->roles = [];
        if ($auth instanceof \yii\rbac\BaseManager) {
            $this->roles = array_map(fn ($role) => $role->name, $auth->getRolesByUser($user->id));
        }
    }

    public function rules()
    {
        return [
            ['active', 'boolean'],
            ['username', 'string', 'max' => 20],
            ['username', function($attribute, $params) {
                $conditions = ['and', ['username' => $this->username]];
                if ($this->_user->id) {
                    $conditions[] = ['<>', 'id', $this->_user->id];
                }
                if (User::find()->where($conditions)->exists()) {
                    $this->addError($attribute, 'User with name "' . $this->username . '" already exists.');
                }
            }],
            ['email', 'email'],
            [['firstName', 'lastName'], 'string', 'max' => 100],
            [['username', 'email'], 'required'],
            ['roles', 'safe'],
        ];
    }

    public function setAttributes($values, $safeOnly = true)
    {
        if (array_key_exists('roles', $values) && !is_array($values['roles'])) {
            $values['roles'] = [];
        }
        parent::setAttributes($values, $safeOnly);
    }

    public function getUser(): User
    {
        return $this->_user;
    }

    public static function getAllRoles(): array
    {
        $auth = Yii::$app->authManager;
        $roles = [];
        if ($auth instanceof \yii\rbac\BaseManager) {
            $roles = array_map(fn ($role) => $role->name, $auth->getRoles());
        }
        return $roles;
    }

    public function process(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = $this->_user->getDb()->beginTransaction();
        try {
            $user = $this->_user;

            // Attributes
            $user->active = $this->active;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->firstName = $this->firstName;
            $user->lastName = $this->lastName;
            $user->save(false);

            // Roles
            $auth = Yii::$app->authManager;
            if ($auth instanceof \yii\rbac\BaseManager) {
                $auth->revokeAll($user->id);
                foreach ($auth->getRoles() as $role) {
                    if (in_array($role->name, $this->roles)) {
                        $auth->assign($role, $user->id);
                    }
                }
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return true;
    }
}
