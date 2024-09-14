import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;

class SignupScreen extends StatefulWidget {
  @override
  _SignupScreenState createState() => _SignupScreenState();
}

class _SignupScreenState extends State<SignupScreen> {
  final TextEditingController _usernameController = TextEditingController();
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  final TextEditingController _confirmPasswordController =
      TextEditingController();

  Future<void> signup() async {
    if (_passwordController.text == _confirmPasswordController.text) {
      final response = await http.post(
        Uri.parse(
            'http://10.0.2.2/myflutter/signup.php'), // Update URL for your backend
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: {
          'username': _usernameController.text,
          'email': _emailController.text,
          'password': _passwordController.text,
        },
      );

      var data = jsonDecode(response.body);
      if (data['status'] == 'success') {
        // Navigate to login page or show success message
        print("Signup Successful!");
      } else {
        // Show error message
        print("Signup Failed: ${data['message'] ?? 'Error occurred'}");
      }
    } else {
      print("Passwords do not match");
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Signup')),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            TextField(
              controller: _usernameController,
              decoration: InputDecoration(labelText: 'Username'),
            ),
            TextField(
              controller: _emailController,
              decoration: InputDecoration(labelText: 'Email'),
            ),
            TextField(
              controller: _passwordController,
              obscureText: true,
              decoration: InputDecoration(labelText: 'Password'),
            ),
            TextField(
              controller: _confirmPasswordController,
              obscureText: true,
              decoration: InputDecoration(labelText: 'Confirm Password'),
            ),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: signup,
              child: Text('Signup'),
            ),
          ],
        ),
      ),
    );
  }
}
