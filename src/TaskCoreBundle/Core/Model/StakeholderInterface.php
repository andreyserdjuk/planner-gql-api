<?php

namespace Planner\TaskCoreBundle\Core\Model;

interface StakeholderInterface
{
    public function getPermissionSet();

    public function getDelegateTo();

    public function getHierarchy();

    public function getDelegateDirection();
}
