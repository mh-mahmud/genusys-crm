<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Agent;

class AgentController extends Controller {

	public function __construct()
    {
        $this->middleware('auth');
    }

	public function index()
    {
        //$agents = Agent::all();
        $agents = Agent::paginate(config('constants.ROW_PER_PAGE'));
        return view('agents.index', compact('agents'));
    }

	function create() {
		return view('agents.create');
	}

    public function store(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'password' => 'required|string',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
       
        if ($request->hasFile('profile_image')) {
            $fileNameWithExt = $request->file('profile_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('profile_image')->move(public_path().'/uploads/agents', $fileNameToStore);
            
        } else {
            
            $fileNameToStore = '';
        }
        $user = User::create([
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'profile_image' => $fileNameToStore,
            'user_type' =>'agent',
            'password' => bcrypt($request->password),
        ]);
        $agent_id = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $agent = new Agent([
            'agent_id' => $agent_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'birth_day' => $request->birth_day,
            'phone_number' => $request->phone_number,
            'status' => $request->status,
            'address' => $request->address,
            'description' => $request->description,
        ]);
        $user->agent()->save($agent);
        return redirect()->route('agents.index')->with('success', 'Agent created successfully.');
    }

    public function show($id)
    {
        $agent = Agent::findOrFail($id);
        $user = User::findOrFail($agent->user_id);
        return view('agents.show', compact('agent', 'user'));
    }

    public function edit($id)
    {
        $agent = Agent::findOrFail($id);
        $user = User::findOrFail($agent->user_id);
        return view('agents.edit', compact('agent', 'user'));
    }


    public function update(Request $request, $id)
    {
        
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            //'email' => 'required|email|unique:users,email,'.$id,
            //'password' => 'required|string',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the user by ID
        $agent = Agent::findOrFail($id);
        $user = User::findOrFail($agent->user_id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->user_type ='agent';
        $user->password = bcrypt($request->password);
        if ($request->hasFile('profile_image')) {
            // Delete the previous profile image
            if ($user->profile_image) {
                $previousImagePath = public_path().'/uploads/agents/'.$user->profile_image;
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }
                $fileNameWithExt = $request->file('profile_image')->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('profile_image')->getClientOriginalExtension();
                $fileNameToStore = $fileName.'_'.time().'.'.$extension;
                $path = $request->file('profile_image')->move(public_path().'/uploads/agents', $fileNameToStore);
                $user->profile_image = $fileNameToStore;
        }
        $user->save();
        $agent = $user->agent;
        $agent->first_name = $request->first_name;
        $agent->last_name = $request->last_name;
        $agent->gender = $request->gender;
        $agent->birth_day = $request->birth_day;
        $agent->phone_number = $request->phone_number;
        $agent->status = $request->status;
        $agent->address = $request->address;
        $agent->description = $request->description;
        

        // Save the updated agent
        $agent->save();

        return redirect()->route('agents.index')->with('success', 'Agent updated successfully.');
    }

    public function search_backup(Request $request)
    {
        $query = Agent::query();

        // Check if agent_id is provided and filter by it
        if ($request->filled('agent_id')) {
            $query->where('agent_id', $request->input('agent_id'));
        }

        // Check if first_name is provided and filter by it
        if ($request->filled('first_name')) {
            $query->where('first_name', 'like', '%' . $request->input('first_name') . '%');
        }

        // Check if last_name is provided and filter by it
        if ($request->filled('last_name')) {
            $query->where('last_name', 'like', '%' . $request->input('last_name') . '%');
        }

        $agents = $query->paginate(config('constants.ROW_PER_PAGE'));

        return view('agents.index', compact('agents'));
    }

    public function search(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'agent_id' => 'required|string', // Modify validation rules as needed
        ]);

        // Extract the search term from the request
        $searchTerm = $request->input('agent_id');

        // Perform the search query
        $agents = Agent::where('agent_id', 'LIKE', "%{$searchTerm}%")->paginate(config('constants.ROW_PER_PAGE'));
    

        // Return the view with the search results
        return view('agents.index', compact('agents'));
    }




    public function destroy($id)
    {
        try {
            // Find the agent by ID
            $agent = Agent::findOrFail($id);
            $user = $agent->user;
            // Delete the profile image file if it exists
            if ($user->profile_image) {
                $imagePath = public_path().'/uploads/agents/'.$user->profile_image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $agent->delete();
            $user->delete();

            return redirect()->route('agents.index')->with('success', 'Agent deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete agent.');
        }
    }


}

