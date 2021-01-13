<?php

namespace Larams\Cms\Http\Controllers\Api;

use Illuminate\Http\Request;
use Larams\Cms\Model;
use Larams\Cms\Repository;

class CrudController extends Controller
{

    protected $requests = [];

    /** @var Model $model */
    protected $model;

    /** @var Repository $repository */
    protected $repository;

    protected $requireValidUser = false;

    protected $itemsPerPage = 100;

    public function __construct(Request $request)
    {
        $modelName = $request->get('model');

        if (!empty($modelName)) {
            if (strpos($modelName, '\\') === false) {
                $modelClassName = 'App\\Model\\' . $modelName;
                $repositoryName = 'App\\Repository\\' . $modelName;
            }
            $this->model = app()->make($modelClassName);
            $this->repository = app()->make($repositoryName);
        }

        if (!empty(request()->get('DBG'))) {
            \DB::enableQueryLog();
        }
    }

    public function callAction($method, $parameters)
    {
        if ( !empty( $this->requests[ $method ])) {
            $request = app()->make( $this->requests[ $method ]);
        }

        return parent::callAction($method, $parameters);
    }

    public function index(Request $request)
    {
        $input = $request->input();

        if (!isset($input['authorized_user_id']) && !auth()->guest()) {
            $input['authorized_user_id'] = auth()->user()->id;
        }

        $currentPage = !empty($input['page']) ? max(0, $input['page']) : 0;
        $input['page'] = $currentPage + 1;

        if (empty($input['limit'])) {
            $input['limit'] = $this->itemsPerPage;
        }

        $itemsPerPage = max( $input['limit'], 0 );
        $items = $this->repository->filter($input);
        unset($input['limit']);
        unset($input['page']);
        $input['count'] = true;

        $grouppingCol = !empty($this->repository->groupping) ? $this->repository->groupping : $this->repository->getModel()->qualifyColumn('id');

        $total = $this->repository->buildQuery($input)->count(\DB::raw('DISTINCT( ' . $grouppingCol . ' )'));

        $totals = null;
        if (!empty($input['totals'])) {
            $totals = $this->repository->totals($input);
        }

        if (empty($itemsPerPage)) {
            $itemsPerPage = $total;
        }

        return $this->json($items)
            ->header('X-Size', $itemsPerPage)
            ->header('X-Total', $total)
            ->header('X-Total-Pages', ceil($total / $itemsPerPage))
            ->header('X-Page', $currentPage);
    }

    protected function json($items)
    {
        if (!empty(request()->input('DBG'))) {
            $log = \DB::getQueryLog();

            foreach ($log as &$queryData) {

                foreach ($queryData['bindings'] as $i => $binding) {
                    if ($binding instanceof \DateTime) {
                        $queryData['bindings'][$i] = $binding->format('\'Y-m-d H:i:s\'');
                    } else {
                        if (is_string($binding)) {
                            $queryData['bindings'][$i] = "'$binding'";
                        }
                    }
                }

                if (!empty($queryData['bindings'])) {
                    $queryData['query'] = str_replace(array('%', '?'), array('%%', '%s'), $queryData['query']);
                    $queryData['query'] = vsprintf($queryData['query'], $queryData['bindings']);
                }

                echo '<div style="padding: 10px; border: 1px solid #eee; font-family: Arial;">' . round($queryData['time'] / 1000,
                        5) . 's : ' . $queryData['query'] . '</div>' . PHP_EOL;
            }

            echo '<pre>';
            var_dump(is_array($items) ? $items : $items->toArray());
            echo '</pre>';

            return response('ok');
        }

        return response()->json($items);
    }

    public function relations(Request $request)
    {
        $input = $request->input();
        $item = $this->model->find($input['id']);
        $related = $item->related($input['id']);
        return response()->json($related);
    }

    public function show(Request $request, $id, $json = true)
    {
        $input = $request->input();
        $input['id'] = $id;

        $item = $this->repository->one($input);

        if (!empty($this->requireValidUser) && $this->hasValidUser( $item )) {
            return response(['error' => 'Not allowed'], 403);
        }

        if ($json) {
            return response()->json($item);
        }

        return $item;

    }

    public function destroy(Request $request, $id)
    {
        $userId = $this->requireValidUser ? auth()->user()->id : null;
        $this->repository->delete($id, $userId);

        return response()->json(array('status' => 'ok'));
    }

    public function update(Request $request, $id, $allowedFields = [])
    {

        $input = $request->input();

        /** @var Model $model */
        $model = $this->model->find($id);
        if (!isset($input['authorized_user_id']) && !auth()->guest()) {
            $input['authorized_user_id'] = auth()->user()->id;
        }

        if (!empty($allowedFields)) {
            $input = array_filter($input, function ($key) use ($allowedFields) {
                return in_array($key, $allowedFields);
            }, ARRAY_FILTER_USE_KEY);
        }

        $this->repository->update($model, $input);

        $model = $this->repository->one(['id' => $id ]);

        return response()->json($model);
    }

    public function store(Request $request)
    {

        $input = $request->input();

        if (!empty($input['id'])) {
            return $this->update($request, $input['id']);
        }

        if (!isset($input['authorized_user_id']) && !auth()->guest()) {
            $input['authorized_user_id'] = auth()->user()->id;
        }

        $model = $this->repository->create($input);

        $model = $this->repository->one(['id' => $model->id ]);

        return response()->json($model);

    }

    protected function hasValidUser( $item )
    {
        return $item->user_id != auth()->user()->id;
    }
}
