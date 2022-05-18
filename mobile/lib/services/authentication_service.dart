import 'package:erasmus_helper/services/user_service.dart';
import 'package:firebase_auth/firebase_auth.dart';

import '../models/user.dart';

class AuthenticationService {
  final FirebaseAuth _firebaseAuth;

  AuthenticationService(this._firebaseAuth);

  Stream<User?> get currentUser => _firebaseAuth.authStateChanges();

  Future<String?> signIn(
      {required String email, required String password}) async {
    try {
      await _firebaseAuth.signInWithEmailAndPassword(
          email: email, password: password);
      return "Signed in";
    } on FirebaseAuthException catch (e) {
      if (e.code == 'user-not-found') {
        return 'No user found for that email.';
      } else if (e.code == 'wrong-password') {
        return 'Wrong password provided for that user.';
      } else {
        return e.message;
      }
    }
  }

  Future<String?> signUp({required UserModel user}) async {
    try {
      UserCredential credential =
          await _firebaseAuth.createUserWithEmailAndPassword(
              email: user.email!, password: user.password!);

      user.uid = credential.user!.uid;
      UserService.addUser(user);

      return "Signed up";
    } on FirebaseAuthException catch (e) {
      if (e.code == 'weak-password') {
        return 'The password provided is too weak.';
      } else if (e.code == 'email-already-in-use') {
        return 'The account already exists for that email.';
      } else {
        return e.message;
      }
    }
  }

  Future<String?> signOut() async {
    try {
      await FirebaseAuth.instance.signOut();
      return "Signed out";
    } on FirebaseAuthException catch (e) {
      return e.message;
    }
  }
}
