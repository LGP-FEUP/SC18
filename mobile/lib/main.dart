import 'package:erasmus_helper/services/authentication_service.dart';
import 'package:erasmus_helper/views/authentication/login.dart';
import 'package:firebase_auth/firebase_auth.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:flutter/material.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:provider/provider.dart';

import 'app_layout.dart';
import 'firebase_options.dart';

void main() async {
  await dotenv.load(fileName: ".env");
  WidgetsFlutterBinding.ensureInitialized();
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  final Color _bluePrimary = const Color(0xFF0038FF);

  MaterialColor createMaterialColor(Color color) {
    List strengths = <double>[.05];
    final swatch = <int, Color>{};
    final int r = color.red, g = color.green, b = color.blue;

    for (int i = 1; i < 10; i++) {
      strengths.add(0.1 * i);
    }
    for (var strength in strengths) {
      final double ds = 0.5 - strength;
      swatch[(strength * 1000).round()] = Color.fromRGBO(
        r + ((ds < 0 ? r : (255 - r)) * ds).round(),
        g + ((ds < 0 ? g : (255 - g)) * ds).round(),
        b + ((ds < 0 ? b : (255 - b)) * ds).round(),
        1,
      );
    }
    return MaterialColor(color.value, swatch);
  }

  Widget _app() {
    return MultiProvider(
      providers: [
        Provider<AuthenticationService>(
            create: (_) => AuthenticationService(FirebaseAuth.instance)),
        StreamProvider(
          create: (context) =>
              context.read<AuthenticationService>().currentUser,
          initialData: null,
        )
      ],
      child: MaterialApp(
        title: 'Erasmus Helper',
        theme: ThemeData(
            primarySwatch: createMaterialColor(_bluePrimary),
            primaryColor: _bluePrimary,
            scaffoldBackgroundColor: const Color(0xFFF1F1F1),
            visualDensity: VisualDensity.adaptivePlatformDensity),
        home: const SafeArea(child: AuthenticationWrapper()),
      ),
    );
  }

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    Future<FirebaseApp> initFireBase = Firebase.initializeApp(
      options: DefaultFirebaseOptions.currentPlatform,
    );

    return FutureBuilder(
      future: initFireBase,
      builder: (context, snapshot) {
        if (snapshot.connectionState == ConnectionState.done) {
          return _app();
        }
        return Container();
      },
    );
  }
}

class AuthenticationWrapper extends StatelessWidget {
  const AuthenticationWrapper({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final firebaseUser = context.watch<User?>();

    if (firebaseUser != null) {
      return const AppLayout();
    }

    return const LoginPage();
  }
}
