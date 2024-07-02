namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ImageKitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $imageKitService;

    public function __construct(ImageKitService $imageKitService)
    {
        $this->imageKitService = $imageKitService;
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'fullname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'photo' => 'nullable|image',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'sex' => 'nullable|string',
            'borrowing_limit' => 'nullable|integer',
            'role_id' => 'required|exists:roles,id',
            'last_login' => 'nullable|date',
        ]);

        $photoUrl = null;
        if ($request->hasFile('photo')) {
            $photoUrl = $this->imageKitService->upload($request->file('photo'));
        }

        User::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo_url' => $photoUrl,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'sex' => $request->sex,
            'borrowing_limit' => $request->borrowing_limit ?? 0,
            'role_id' => $request->role_id,
            'last_login' => $request->last_login,
        ]);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'fullname' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable',
            'photo' => 'nullable|image',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'sex' => 'nullable|string',
            'borrowing_limit' => 'nullable|integer',
            'role_id' => 'required|exists:roles,id',
            'last_login' => 'nullable|date',
        ]);

        $photoUrl = $user->photo_url;
        if ($request->hasFile('photo')) {
            $photoUrl = $this->imageKitService->upload($request->file('photo'));
        }

        $user->update([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'photo_url' => $photoUrl,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'sex' => $request->sex,
            'borrowing_limit' => $request->borrowing_limit ?? 0,
            'role_id' => $request->role_id,
            'last_login' => $request->last_login,
        ]);

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
