<?php
/**
 * This file is part of tomkyle/rbac.
 *
 * Copyright (c) 2014 Carsten Witt
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace tomkyle\AccessControlList;


use \tomkyle\Roles\RolesAwareInterface;


/**
 * Defines methods for objects dealing with Access Control Lists
 *
 * @author  Carsten Witt <tomkyle@posteo.de>
 */
interface AccessControlListAwareInterface
{

    /**
     * Authorization method for services:
     *
     * Checks if the role-aware client passed is allowed (authorized)
     * to use the service.
     *
     * @param RolesAwareInterface $client
     * @return bool
     */
    public function isAllowed(RolesAwareInterface $client);


    /**
     * Stores an ACL for the service.
     *
     * @param  AccessControlListInterface $acl
     * @return AccessControlListAwareInterface Fluent Interface
     */
    public function setAccessControlList(AccessControlListInterface $acl);


    /**
     * Returns the service's ACL instance.
     *
     * @return AccessControlListInterface
     */
    public function getAccessControlList();


}
