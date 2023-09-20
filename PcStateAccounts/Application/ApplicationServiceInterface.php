<?php

namespace Core\Application;

interface ApplicationServiceInterface {

    public function execute(ApplicationRequestInterface $request): ApplicationResponseInterface;

}