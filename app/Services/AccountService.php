<?php
namespace App\Services;

use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AccountService
{
    public function getAllAccounts($perPage = 10)
    {
        return Account::paginate($perPage);
    }

    public function getAccountById($id)
    {
        return Account::find($id);
    }

    public function createAccount($data)
    {
        $data['password'] = Hash::make($data['password']);
        $account          = Account::create($data);

        Log::info("Account created: ", $account->toArray());

        return $account;
    }

    public function updateAccount($id, $data)
    {
        $account = Account::find($id);
        if (! $account) {
            return null;
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $account->update($data);

        Log::info("Account updated: ", $account->toArray());

        return $account;
    }

    public function deleteAccount($id)
    {
        $account = Account::find($id);
        if (! $account) {
            return false;
        }

        $account->delete();

        Log::info("Account deleted: ", ['registerID' => $id]);

        return true;
    }
}
