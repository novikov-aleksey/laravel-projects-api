<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'statuses',
    ];

    /**
     * Planned project status
     */
    const STATUS_PLANNED = 'planned';

    /**
     * Status of the project which is currently running
     */
    const STATUS_RUNNING = 'running';

    /**
     * Status of the project which is currently on hold
     */
    const STATUS_ON_HOLD = 'on_hold';

    /**
     * Status of the project which is currently finished
     */
    const STATUS_FINISHED = 'finished';

        /**
     * Status of the project which is currently canceled
     */
    const STATUS_CANCEL = 'cancel';

    /**
     * @var array array representation of the basic statues
     */
    public static $statuses = [
        self::STATUS_PLANNED,
        self::STATUS_ON_HOLD,
        self::STATUS_RUNNING,
        self::STATUS_FINISHED,
        self::STATUS_CANCEL,
    ];

    /**
     * Change status of the project by provided one
     *
     * @param string $status Changed status
     * @return $this|bool Current Model instance if everything is fine | False in case if provided status were wrong
     */
    private function changeStatusTo($status = self::STATUS_RUNNING)
    {
        if (!in_array($status, array_values(self::$statuses))) {
            return false;
        }

        $this->status = $status;
        $this->save();

        return $this;
    }


    /**
     * Cancel project
     *
     * @return \App\Project|bool
     */
    public function cancelProject()
    {
        return $this->changeStatusTo(self::STATUS_CANCEL);
    }

    /**
     * Finish project
     *
     * @return \App\Project|bool
     */
    public function finishProject()
    {
        return $this->changeStatusTo(self::STATUS_FINISHED);
    }

    /**
     * Plan project
     *
     * @return \App\Project|bool
     */
    public function planProject()
    {
        return $this->changeStatusTo(self::STATUS_PLANNED);
    }

    /**
     * Run project
     *
     * @return \App\Project|bool
     */
    public function runProject()
    {
        return $this->changeStatusTo(self::STATUS_RUNNING);
    }

    /**
     * Put project on hold
     *
     * @return \App\Project|bool
     */
    public function onHoldProject()
    {
        return $this->changeStatusTo(self::STATUS_ON_HOLD);
    }
}
