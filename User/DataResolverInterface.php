<?php

namespace SchulIT\KivutoBundle\User;

interface DataResolverInterface {
    public function getUsername();

    public function getFirstname();

    public function getLastname();

    public function getAcademicStatus();

    public function getEmail();
}