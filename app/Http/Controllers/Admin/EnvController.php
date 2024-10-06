<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class EnvController extends Controller
{
    public function edit()
    {
        return view('admin.smtp.config');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'host' => 'required',
            'username' => 'required',
            'password' => 'required',
            'port' => 'required|numeric',
            'from_address' => 'required|email',
            'encryption' => 'required'
        ]);

        $this->updateEnvVariable('MAIL_HOST', $data['host']);
        $this->updateEnvVariable('MAIL_PORT', $data['port']);
        $this->updateEnvVariable('MAIL_USERNAME', $data['username']);
        $this->updateEnvVariable('MAIL_PASSWORD', $data['password']);
        $this->updateEnvVariable('MAIL_ENCRYPTION', $data['encryption']);
        $this->updateEnvVariable('MAIL_FROM_ADDRESS', $data['from_address']);

        return redirect()->back()->with('success', 'SMTP configuration updated successfully.');
    }

    private function updateEnvVariable($keyToUpdate, $value)
    {
        $envFile = base_path('.env');
        $envContents = file($envFile);
        if (file_exists($envFile)) {
            foreach ($envContents as $key => &$line) {
                if (strpos($line, "{$keyToUpdate}=") === 0) {
                    $envContents[$key] = "{$keyToUpdate}={$value}\n";
                }
            }
            file_put_contents($envFile, implode('', $envContents));
        }
    }
}
