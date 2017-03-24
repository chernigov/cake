<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Debts Model
 *
 * @property \Cake\ORM\Association\HasMany $Payments
 *
 * @method \App\Model\Entity\Debt get($primaryKey, $options = [])
 * @method \App\Model\Entity\Debt newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Debt[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Debt|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Debt patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Debt[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Debt findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DebtsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('debts');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Payments', [
            'foreignKey' => 'debt_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->allowEmpty('description');

        $validator
            ->decimal('balance')
            ->requirePresence('balance', 'create')
            ->notEmpty('balance');

        $validator
            ->decimal('interest')
            ->requirePresence('interest', 'create')
            ->notEmpty('interest');

        return $validator;
    }
}
