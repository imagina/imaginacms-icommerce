<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request as Requests;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Order_History;
use Modules\Icommerce\Http\Requests\CreateOrder_HistoryRequest;
use Modules\Icommerce\Http\Requests\UpdateOrder_HistoryRequest;
use Modules\Icommerce\Repositories\Order_HistoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Illuminate\Support\Facades\Input;
use Request;

use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Setting\Contracts\Setting;

class Order_HistoryController extends AdminBaseController
{
    /**
     * @var Order_HistoryRepository
     */
    private $order_history;
    private $order;
    private $setting;

    public function __construct(Order_HistoryRepository $order_history, OrderRepository $order,Setting $setting)
    {
        parent::__construct();

        $this->order_history = $order_history;
        $this->order = $order;
        $this->setting = $setting;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$order_history = $this->order_history->all();

        return view('icommerce::admin.order_history.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.order_history.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrder_HistoryRequest $request
     * @return Response
     */
    public function store(CreateOrder_HistoryRequest $request)
    {
        $this->order_history->create($request->all());

        return redirect()->route('admin.icommerce.order_history.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::order_history.title.order_history')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Order_History $order_history
     * @return Response
     */
    public function edit(Order_History $order_history)
    {
        return view('icommerce::admin.order_history.edit', compact('order_history'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Order_History $order_history
     * @param  UpdateOrder_HistoryRequest $request
     * @return Response
     */
    public function update(Order_History $order_history, UpdateOrder_HistoryRequest $request)
    {
        $this->order_history->update($order_history, $request->all());

        return redirect()->route('admin.icommerce.order_history.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::order_history.title.order_history')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order_History $order_history
     * @return Response
     */
    public function destroy(Order_History $order_history)
    {
        $this->order_history->destroy($order_history);

        return redirect()->route('admin.icommerce.order_history.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::order_history.title.order_history')]));
    }


    /**
     * Add Order History Via AJAX
     *
     * @param  
     * @return Response
    */
    public function addHistory()
    {
        
        if(Request::ajax()){

            $response = array();
            $response['status'] = 'error'; //default
            
            $orderID = Input::get("orderID");
            $newStatus = Input::get("newStatus");
            $notify = Input::get("notify");
            $newStatusText = Input::get("newStatusText");
            $comment = Input::get("comment");
           
            $param = array(
                'order_id'  => $orderID,
                'status'    => $newStatus,
                'notify'    => $notify, 
                'comment'   => $comment
            );

            try{

                $history = $this->order_history->create($param);
                $order = $this->order->find($orderID);
                $order->order_status = $newStatus;
                $order->update();

                if($notify==1){

                    $email_from = $this->setting->get('icommerce::from-email');
                    $email_to = explode(',',$this->setting->get('icommerce::form-emails'));
                    $sender  = $this->setting->get('core::site-name');

                    $msjTheme = "icommerce::email.history_order";
                    $msjSubject = trans('icommerce::common.emailSubject.history');
                    $msjIntro = trans('icommerce::common.emailIntro.history');

                    $user = "{$order->first_name} {$order->last_name}";

                    $content=[
                        'order'=> $order->id,
                        'user' => $user,
                        'status' => $newStatusText,
                        'comment' => $comment
                    ];

                    $mailUser = icommerce_emailSend(['email_from'=>[$email_from],'theme' => $msjTheme,'email_to' => $order->email,'subject' => $msjSubject, 'sender'=>$sender,'data' => array('title' => $msjSubject,'intro'=> $msjIntro,'content'=>$content)]);

                }

                $response['date'] = $history->created_at;
                $response['status'] = 'success';
                return response()->json($response);

            }catch(Exception $e){

                $response['message'] = $e->getMessage();
                return response()->json($response);  
            }

        }
  
    }


}
