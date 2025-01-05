<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Laravel Auth API",
 *     description="API Documentation for Authentication"
 * )
 */
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['login', 'register']);
    }
    /**
     * @OA\Post(
     *     path="/api/user-management/users/register",
     *     tags={"Authentication"},
     *     summary="Register new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"firstName","lastName","email","password","birthdate","address"},
     *             @OA\Property(property="firstName", type="string", example="John"),
     *             @OA\Property(property="lastName", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="birthdate", type="string", format="date", example="1990-01-01"),
     *             @OA\Property(property="address", type="string", example="123 Main St")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation Error"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     type="array",
     *                     @OA\Items(type="string", example="The email has already been taken.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function register(Request $request)
    {
        try {
            // Custom validation messages
            $messages = [
                'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau login jika ini adalah email Anda.',
                'email.email' => 'Format email tidak valid.',
                'firstName.required' => 'Nama depan wajib diisi.',
                'lastName.required' => 'Nama belakang wajib diisi.',
                'password.min' => 'Password minimal 8 karakter.',
                'birthdate.date' => 'Format tanggal lahir tidak valid.',
                'address.required' => 'Alamat wajib diisi.'
            ];

            // Validate request data
            $validator = Validator::make($request->all(), [
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'email' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:users,email'
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                ],
                'birthdate' => 'required|date',
                'address' => 'required|string'
            ], $messages);

            if ($validator->fails()) {
                // Check specifically for email unique validation failure
                if ($validator->errors()->has('email')) {
                    $existingUser = User::where('email', $request->email)->first();
                    if ($existingUser) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Email sudah terdaftar',
                            'errors' => [
                                'email' => ['Email ini sudah terdaftar. Silakan gunakan email lain atau login jika ini adalah email Anda.']
                            ]
                        ], 422);
                    }
                }

                throw new ValidationException($validator);
            }

            DB::beginTransaction();

            try {
                // Create new user
                $user = User::create([
                    'first_name' => $request->firstName,
                    'last_name' => $request->lastName,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'birthdate' => $request->birthdate,
                    'address' => $request->address
                ]);

                $token = $user->createToken('auth_token')->plainTextToken;


                DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Registrasi berhasil',
                    'data' => [
                        'email' => $user->email,
                        'user_id' => $user->id,
                        'token' => $token
                    ]
                ], 201);

            } catch (Exception $e) {
                DB::rollBack();
                throw new Exception('Gagal membuat akun pengguna');
            }

        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/user-management/users/login",
     *     summary="Login user",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Login successful"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $credentials = $request->only('email', 'password');

            // Check credentials manually
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            // Create new Sanctum token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'data' => [
                    'email' => $user->email,
                    'user_id' => $user->id,
                    'token' => $token
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Login failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
