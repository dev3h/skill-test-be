<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * @OA\Get(
     *     path="/api/accounts",
     *     tags={"Accounts"},
     *     summary="Get a list of accounts",
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of accounts per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of accounts",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Account"))
     *     )
     * )
     */
    public function index(Request $request)
    {
        return response()->json($this->accountService->getAllAccounts($request->input('per_page', 10)));
    }

    /**
     * @OA\Get(
     *     path="/api/accounts/{id}",
     *     tags={"Accounts"},
     *     summary="Get account details by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Account ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Account details",
     *         @OA\JsonContent(ref="#/components/schemas/Account")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Account not found"
     *     )
     * )
     */
    public function show($id)
    {
        $account = $this->accountService->getAccountById($id);
        if (! $account) {
            return response()->json(['message' => 'Account not found'], 404);
        }
        return response()->json($account);
    }

    /**
     * @OA\Post(
     *     path="/api/accounts",
     *     tags={"Accounts"},
     *     summary="Create a new account",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AccountRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Account created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Account")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(AccountRequest $request)
    {
        $account = $this->accountService->createAccount($request->validated());
        return response()->json($account, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/accounts/{id}",
     *     tags={"Accounts"},
     *     summary="Update an account",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Account ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AccountRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Account updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Account")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Account not found"
     *     )
     * )
     */
    public function update(AccountRequest $request, $id)
    {
        $account = $this->accountService->updateAccount($id, $request->validated());
        if (! $account) {
            return response()->json(['message' => 'Account not found'], 404);
        }
        return response()->json($account);
    }

    /**
     * @OA\Delete(
     *     path="/api/accounts/{id}",
     *     tags={"Accounts"},
     *     summary="Delete an account",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Account ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Account deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Account not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        if (! $this->accountService->deleteAccount($id)) {
            return response()->json(['message' => 'Account not found'], 404);
        }
        return response()->json(['message' => 'Account deleted'], 200);
    }
}
