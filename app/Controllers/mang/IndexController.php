<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Controllers\mang;

use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
// use Swoft\View\Bean\Annotation\View;
// use Swoft\Http\Message\Server\Response;

/**
 * Class MangIndexController
 * @Controller(prefix="/mang/index")
 * @package App\Controllers
 */
class IndexController{
    /**
     * this is a example action. access uri path: /mang/index
     * @RequestMapping(route="/mang/index", method={RequestMethod::GET, RequestMethod::POST})
     * @return array
     */
    public function index(): array
    {
        return ['item0', 'item1'];
    }
}
