<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Agent;
use App\Services\AgentService;
use App\Services\UserService;
use App\Helpers\Helper;

class AgentController extends Controller {

	// public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    protected $agentService;

    public function __construct(AgentService $agentService)
    {
        $this->agentService = $agentService;

        // $this->middleware('auth');
    }

	public function index()
    {
        
        $agents = $this->agentService->getAllAgents();
        return view('agents.index', compact('agents'));
    }

	function create() {
        $agentData['role_list'] = $this->agentService->get_all_role();
		return view('agents.create', $agentData);
	}

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
           
        ]);
       
        // If validation fails,return error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = $this->agentService->create_agent($request);
        Helper::storeLog("Agent created successfully", "Agent", "Create Agent");
        return redirect()->route('agents-index')->with('success', 'Agent created successfully.');
    }


    public function show($id)
    {
        $agentData = $this->agentService->getAgentWithUser($id);
        return view('agents.show', $agentData);
    }

   
    public function edit($id)
    {
        $agentData = $this->agentService->getAgentEditData($id);
        $agentData['role_list'] = $this->agentService->get_all_role();

        return view('agents.edit', $agentData);
    }


    public function update(Request $request, $id)
    {    //dd($request);die();
        
        $request->validate([
            'first_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'username' => 'required|string|unique:users,username,' . $request->id,
            'last_name' => 'required|string',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

       
        $this->agentService->updateAgent($request, $id);
        Helper::storeLog("Agent updated successfully", "Agent", "Edit Agent");
        return redirect()->route('agents-index')->with('success', 'Agent updated successfully.');
    }

  

    public function search(Request $request)
    {

        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('agents-index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);
       
        $agents = $this->agentService->searchAgents($request);
        return view('agents.index', compact('agents'));
    }




    public function destroy($id)
    {
        try {
            $this->agentService->deleteAgentAndUser($id);
            Helper::storeLog("Agent deleted successfully", "Agent", "Delete Agent");
            return redirect()->route('agents-index')->with('success', 'Agent deleted successfully.');
        } catch (\Exception $e) {
           return redirect()->back()->with('error', $e->getMessage());
        }
    }


}

