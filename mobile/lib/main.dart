import 'package:firebase_auth/firebase_auth.dart';
import 'package:flutter/material.dart';

import 'package:firebase_core/firebase_core.dart';
import 'package:provider/provider.dart';
import 'firebase_options.dart';

import 'package:erasmus_helper/views/login.dart';
import 'package:erasmus_helper/services/authentication_service.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';

void main() async {
  await dotenv.load(fileName: ".env");
  WidgetsFlutterBinding.ensureInitialized();
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  Widget _app() {
    return MultiProvider(
      providers: [
        Provider<AuthenticationService>(
            create: (_) => AuthenticationService(FirebaseAuth.instance)),
        StreamProvider(
          create: (context) =>
          context.read<AuthenticationService>().authStateChanges,
          initialData: null,
        )
      ],
      child: MaterialApp(
        title: 'Flutter Demo',
        theme: ThemeData(
            primarySwatch: Colors.blue,
            visualDensity: VisualDensity.adaptivePlatformDensity),
        home: const AuthenticationWrapper(),
      ),
    );
  }

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    Future<FirebaseApp> _initFireBase = Firebase.initializeApp(
      options: DefaultFirebaseOptions.currentPlatform,
    );

    return FutureBuilder(
      future: _initFireBase,
      builder: (context, snapshot) {
        if (snapshot.connectionState == ConnectionState.done) {
          return _app();
        }
        return Container();
      },
    );
  }
}

class MyHomePage extends StatefulWidget {
  const MyHomePage({Key? key, required this.title}) : super(key: key);

  final String title;

  @override
  State<MyHomePage> createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(widget.title),
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            ElevatedButton(
              onPressed: () {
                context.read<AuthenticationService>().signOut().then((value) =>
                    Navigator.push(
                        context,
                        MaterialPageRoute(
                            builder: (context) => const LoginPage())));
              },
              child: const Text("Sign out"),
            )
          ],
        ),
      ),
    );
  }
}

class AuthenticationWrapper extends StatelessWidget {
  const AuthenticationWrapper({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final firebaseUser = context.watch<User?>();

    if (firebaseUser != null) {
      return const MyHomePage(title: "Homepage");
    }

    return const LoginPage();
  }
}
