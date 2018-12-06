<?php
/**
 * SkinController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use XePresenter;
use Xpressengine\Skin\SkinHandler;

/**
 * Class SkinController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class SkinController extends Controller
{
    /**
     * Set the skin to the target instance
     *
     * @param Request     $request     request
     * @param SkinHandler $skinHandler SkinHandler
     * @return \Xpressengine\Presenter\Presentable
     */
    public function putAssign(Request $request, SkinHandler $skinHandler)
    {
        $this->validate($request, [
            'skinId' => 'required',
            'instanceId' => 'required'
        ]);

        $skinInstanceId = $request->get('instanceId');
        $skinId = $request->get('skinId');
        $mode = $request->get('mode', 'desktop');

        $skin = $skinHandler->get($skinId);
        $skinHandler->assign($skinInstanceId, $skin, $mode);

        return XePresenter::makeApi(
            ['type' => 'success', 'message' => xe_trans('xe::saved'), 'skinId' => $skinId, 'skinTitle' => $skin->getTitle()]
        );
    }

    /**
     * Show the setting form for the skin of instance.
     *
     * @param Request     $request     request
     * @param SkinHandler $skinHandler SkinHandler instance
     * @return mixed
     */
    public function getSetting(Request $request, SkinHandler $skinHandler)
    {
        $this->validate($request, [
            'skinId' => 'required',
            'instanceId' => 'required'
        ]);

        $skinInstanceId = $request->get('instanceId');
        $skinId = $request->get('skinId');

        $skinConfig = $skinHandler->getStore()->getConfigs($skinInstanceId, $skinId);

        $skin = $skinHandler->get($skinId, $skinConfig);

        $view = $skin->renderSetting($skinConfig);

        return api_render('skin.setting', compact('skinId', 'skinInstanceId', 'view'));
    }

    /**
     * Save the setting for the skin of instance.
     *
     * @param Request     $request     request
     * @param SkinHandler $skinHandler SkinHandler instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function postSetting(Request $request, SkinHandler $skinHandler)
    {
        $this->validate($request, [
            'skinId' => 'required',
            'instanceId' => 'required'
        ]);

        $skinInstanceId = $request->get('instanceId');
        $skinId = $request->get('skinId');

        $config = $request->except('instanceId', 'skinId', '_token');

        $skin = $skinHandler->get($skinId);

        // 각 스킨에게 config값을 전처리 할 기회를 준다.
        $config = $skin->resolveSetting($config);

        $skin->setting($config);

        $skinHandler->saveConfig($skinInstanceId, $skin);

        return XePresenter::makeApi(
            ['type' => 'success', 'message' => xe_trans('xe::saved'), 'skinId' => $skinId, 'skinTitle' => $skin->getTitle()]
        );
    }
}
