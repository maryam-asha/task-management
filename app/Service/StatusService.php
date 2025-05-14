<?php

namespace App\Service;

use App\Models\Status;

class StatusService
{
    /**
     * Retrieve status .
     *
     * @param
     * @return array
     */
    public function getStatuses()
    {
        $statuses = Status::all();

        return $statuses;
    }
    /**
     * Create a new status.
     *
     * @param array $data
     * @return Status
     */
    public function createStatus(array $data): Status
    {
        return Status::create($data);
    }


    /**
     * show a status.
     *
     * @param Status $status
     * @return Status
     */
    public function showStatus(Status $status): Status
    {
        return $status;
    }

    /**
     * Update an existing status.
     *
     * @param Status $status
     * @param array $data
     * @return Status
     */
    public function updateStatus(Status $status, array $data): Status
    {
        $status->update($data);
        return $status;
    }
    /**
     * Delete a status.
     *
     * @param Status $status
     * @return bool
     */
    public function deleteStatus(Status $status): bool
    {
        return $status->delete();
    }
}
