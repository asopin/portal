<?php
/**
 * @var $model Vacancy
 */
?>

<h1><?= Yii::t('main', 'vacancy.details')?></h1>

<?php if ($model->status == Vacancy::STATUS_CLOSED): ?>
    <div class="alert alert-danger"><?= Yii::t('main', 'vacancy.is_closed') ?></div>
<?php endif ?>

    <div class="alert alert-block">
        <?= Yii::t('main', 'company') . ': ' . $model->company->name ?>
        <?php if (!$model->isNewRecord): ?>
            [ <?= $model->getAttributeLabel('created_at') . ': ' . $model->created_at ?> ]
            [ <?= $model->getAttributeLabel('updated_at') . ': ' . $model->updated_at ?> ]
        <?php endif; ?>

    </div>

<?php
$this->widget('bootstrap.widgets.TbDetailView', [
        'data' => $model,
        'attributes' => [
            'id',
            [
                'name' => 'status',
                'value' => VacancyHelper::statusName($model),
                'type' => 'html'
            ],
            'city.city_name',
            [
                'name' => 'user_id',
                'value' => function (Vacancy $vacancy) {
                    $users = CompanyHelper::userList($vacancy->company_id);

                    return $users[$vacancy->user_id];
                },
            ],
            'name',
            'description',
            'requirements',
            'housing:boolean',
            'company.name',
            [
                'name' => 'created_at',
                'value' => function(Vacancy $vacancy) {
                    $creator = '--';
                    if(!empty($vacancy->creator)) {
                        $creator = $vacancy->creator->getFirstLastName();
                    }
                    return $creator . ": " . Yii::app()->dateFormatter->formatDateTime($vacancy->created_at, "long");
                },
            ],
            [
                'name' => 'updated_at',
                'value' => function(Vacancy $vacancy) {
                    $updater = '--';
                    if(!empty($vacancy->updater)) {
                        $updater = $vacancy->updater->getFirstLastName();
                    }
                    return $updater . ": " . Yii::app()->dateFormatter->formatDateTime($vacancy->created_at, "long");
                },
            ],
            [
                'name' => 'close_time',
                'value' => Yii::app()->dateFormatter->formatDateTime($model->close_time, "long"),
            ],
            [
                'name' => 'positions',
                'value' => VacancyHelper::positionsAsString($model)
            ],
            [
                'name' => 'educations',
                'value' => VacancyHelper::educationsAsString($model)
            ],
            [
                'name' => 'categories',
                'value' => VacancyHelper::categoriesAsString($model)
            ],
        ]
    ]
);