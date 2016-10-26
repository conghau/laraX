<?php

namespace App\Http\Controllers\Admin;

use App\Models;
use App\Repositories\MenuRepositoryInterface;
use App\Repositories\SettingRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use TCH\LaraXConfig;

class SettingController extends BaseAdminController {
    public $bodyClass = 'setting-controller', $routeLink = 'settings';
    protected $repoSetting;

    public function __construct(SettingRepositoryInterface $repoSetting) {
        parent::__construct('settings');

        $this->repoSetting = $repoSetting;
        $this->setPageTitle('Settings', 'manage website settings');
    }

    public function getIndex(Request $request) {
        $settings = $this->repoSetting->getAllSetting();

        return view('admin.settings.index', array('settings' => $settings));
    }

    public function postIndex(Request $request) {
        $data = $request->except([
            '_token',
        ]);
        $data['construction_mode'] = ($request->has('construction_mode')) ? 1 : 0;
        $data['show_admin_bar'] = ($request->has('show_admin_bar')) ? 1 : 0;
        $result = $this->repoSetting->updateSetting($data);
        if (!$result) {
            $this->setFlashMessages(LaraXConfig::MESSAGE_TYPE_ERROR, 'error');
        }
        else {
            $this->setFlashMessages(LaraXConfig::MESSAGE_TYPE_SUCCESS, 'success');
            Session::flush();
        }
        $this->showFlashMessages();

        return redirect()->back();
    }

    public function getLanguages(Request $request) {
        $this->setPageTitle('Languages', 'manage website languages');
        $this->setBodyClass($this->bodyClass . ' languages-setting-page');

        $this->loadAdminMenu($this->routeLink . '/languages');

        return $this->viewAdmin('settings.languages');
    }

    public function postLanguages(Request $request, Models\Language $object) {
        /**
         * Paging
         **/
        $offset = $request->get('start', 0);
        $limit = $request->get('length', 10);
        $paged = ($offset + $limit) / $limit;
        Paginator::currentPageResolver(function () use ($paged) {
            return $paged;
        });

        $records = [];
        $records["data"] = [];

        /*Group actions*/
        if ($request->get('customActionType', NULL) == 'group_action') {
            $records["customActionStatus"] = "danger";
            $records["customActionMessage"] = "Group action did not completed. Some error occurred.";
            $ids = (array) $request->get('id', []);
            $result = $object->updateMultiple($ids, [
                'status' => $request->get('customActionValue', 0),
            ], TRUE);
            if (!$result['error']) {
                $records["customActionStatus"] = "success";
                $records["customActionMessage"] = "Group action has been completed.";
            }
        }

        /*
         * Sortable data
         */
        $orderBy = $request->get('order')[0]['column'];
        switch ($orderBy) {
            case 1: {
                $orderBy = 'id';
            }
                break;
            case 2: {
                $orderBy = 'language_name';
            }
                break;
            case 3: {
                $orderBy = 'language_code';
            }
                break;
            case 4: {
                $orderBy = 'default_locale';
            }
                break;
            case 5: {
                $orderBy = 'currency';
            }
                break;
            case 6: {
                $orderBy = 'status';
            }
                break;
            default: {
                $orderBy = 'id';
            }
                break;
        }
        $orderType = $request->get('order')[0]['dir'];

        $getByFields = [];
        if ($request->get('language_name', NULL) != NULL) {
            $getByFields['language_name'] = [
                'compare' => 'LIKE',
                'value' => $request->get('language_name')
            ];
        }
        if ($request->get('language_code', NULL) != NULL) {
            $getByFields['language_code'] = [
                'compare' => '=',
                'value' => $request->get('language_code')
            ];
        }
        if ($request->get('status', NULL) != NULL) {
            $getByFields['status'] = [
                'compare' => '=',
                'value' => $request->get('status')
            ];
        }

        $items = $object->searchBy($getByFields, [$orderBy => $orderType], TRUE, $limit);

        $iTotalRecords = $items->total();
        $sEcho = intval($request->get('sEcho'));

        foreach ($items as $key => $row) {
            $status = '<span class="label label-success label-sm">Activated</span>';
            if ($row->status != 1) {
                $status = '<span class="label label-danger label-sm">Disabled</span>';
            }

            $records["data"][] = array(
                '<input type="checkbox" name="id[]" value="' . $row->id . '">',
                $row->id,
                $row->language_name,
                $row->language_code,
                $row->default_locale,
                $row->currency,
                $status,
                '<a class="fast-edit" title="Fast edit">Fast edit</a>',
            );
        }

        $records["sEcho"] = $sEcho;
        $records["iTotalRecords"] = $iTotalRecords;
        $records["iTotalDisplayRecords"] = $iTotalRecords;

        return response()->json($records);
    }

    public function postFastEditLanguages(Request $request, Models\Language $object) {
        $data = [
            'id' => $request->get('args_0', NULL),
            'language_name' => $request->get('args_1', NULL),
            'language_code' => $request->get('args_2', NULL),
            'default_locale' => $request->get('args_3', NULL),
            'currency' => $request->get('args_4', NULL),
        ];

        $result = $object->fastEdit($data, FALSE, TRUE);
        return response()->json($result, $result['response_code']);
    }
}
