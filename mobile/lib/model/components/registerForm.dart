import 'package:erasmus_helper/model/components/registerInput.dart';
import 'package:flutter/material.dart';
import 'package:form_field_validator/form_field_validator.dart';

class RegisterForm extends StatefulWidget {
  const RegisterForm({Key? key}) : super(key: key);

  @override
  State<StatefulWidget> createState() => _RegisterFormState();
}

class _RegisterFormState extends State<RegisterForm> {
  final _formKey = GlobalKey<FormState>();

  // Generates a styled text input given a set of options
  Row genInputRow(BuildContext context, RegisterInput input) {
    return Row(children: [
      Expanded(
          child: Padding(
              padding: const EdgeInsets.only(top: 10, left: 10, right: 10),
              child: input))
    ]);
  }

  List<Widget> genInputs(BuildContext context) {
    final emailInput = genInputRow(context, RegisterInput(
        keyboard: TextInputType.emailAddress,
        icon: const Icon(Icons.email),
        hintText: "Email address",
        validator: EmailValidator(errorText: "Invalid email.")));

    final passwordValidator = MultiValidator([
      RequiredValidator(errorText: 'Password is required.'),
      MinLengthValidator(8,
          errorText: 'Password must be at least 8 digits long.'),
      PatternValidator(r'(?=.*?[#?!@$%^&*-])',
          errorText: 'Passwords must have at least one special character.')
    ]);

    final passwordInput = genInputRow(context, RegisterInput(
      keyboard: TextInputType.text,
      icon: const Icon(Icons.key),
      hintText: "Password",
      validator: passwordValidator,
      hidable: true,));

    final confirmPasswordInput = genInputRow(context, RegisterInput(
        keyboard: TextInputType.text,
        icon: const Icon(Icons.key),
        hintText: "Confirm password",
        validator: passwordValidator,
        hidable: true));

    final nameInput = genInputRow(context, RegisterInput(
        keyboard: TextInputType.text,
        icon: const Icon(Icons.account_circle_rounded),
        hintText: "Name",
        validator: MultiValidator([
          RequiredValidator(errorText: "Name is required."),
          MaxLengthValidator(32, errorText: "Max characters reached.")
        ])));

    return [emailInput, passwordInput, confirmPasswordInput, nameInput];
  }

  @override
  Widget build(BuildContext context) {
    const title = Padding(
        padding: EdgeInsets.only(left: 10),
        child: Text(
          'Sign up',
          style: TextStyle(fontWeight: FontWeight.bold, fontSize: 18),
        ));

    return Form(
        key: _formKey,
        child: Column(children: [
          Row(
            children: const [title],
          ),
          ...genInputs(context)
        ]));
  }
}