import 'package:flutter/material.dart';
import 'package:form_field_validator/form_field_validator.dart';

class FormInput extends StatefulWidget {
  final TextInputType keyboard;
  final Icon icon;
  final String hintText;
  final FieldValidator validator;
  final bool hidable;
  final TextEditingController controller;

  const FormInput({
    Key? key,
    required this.keyboard,
    required this.icon,
    required this.hintText,
    required this.validator,
    this.hidable = false,
    required this.controller,
  }) : super(key: key);

  @override
  State<StatefulWidget> createState() => _FormInputState();
}

class _FormInputState extends State<FormInput> {
  bool _hidden = true;

  @override
  Widget build(BuildContext context) {
    return TextFormField(
        keyboardType: widget.keyboard,
        obscureText: widget.hidable ? _hidden : false,
        controller: widget.controller,
        decoration: InputDecoration(
          icon: widget.icon,
          hintText: widget.hintText,
          suffixIcon: widget.hidable
              ? GestureDetector(
                  onTap: () {
                    setState(() {
                      _hidden = !_hidden;
                    });
                  },
                  child:
                      Icon(_hidden ? Icons.visibility : Icons.visibility_off),
                )
              : null,
        ),
        validator: widget.validator);
  }
}

class EmailInput extends FormInput {
  EmailInput({Key? key, required TextEditingController controller})
      : super(
            key: key,
            keyboard: TextInputType.emailAddress,
            icon: const Icon(Icons.email),
            hintText: "Email address",
            validator: MultiValidator([
              RequiredValidator(errorText: 'Password is required.'),
              EmailValidator(errorText: "Invalid email.")
            ]),
            controller: controller);
}

class PasswordInput extends FormInput {
  PasswordInput({Key? key, required TextEditingController controller})
      : super(
            key: key,
            keyboard: TextInputType.text,
            icon: const Icon(Icons.key),
            hintText: "Password",
            validator: RequiredValidator(errorText: 'Password is required.'),
            controller: controller,
            hidable: true);
}

class NewPasswordInput extends FormInput {
  NewPasswordInput({Key? key, required TextEditingController controller})
      : super(
      key: key,
      keyboard: TextInputType.text,
      icon: const Icon(Icons.key),
      hintText: "Password",
      validator: MultiValidator([
        RequiredValidator(errorText: 'Password is required.'),
        MinLengthValidator(8,
            errorText: 'Password must be at least 8 digits long.'),
      ]),
      controller: controller,
      hidable: true);
}

class ConfirmPasswordInput extends FormInput {
  ConfirmPasswordInput(
      {Key? key,
      required TextEditingController controller,
      required TextEditingController passwordController})
      : super(
            key: key,
            keyboard: TextInputType.text,
            icon: const Icon(Icons.key),
            hintText: "Confirm password",
            validator: ConfirmPasswordValidator(passwordController),
            controller: controller,
            hidable: true);
}

class ConfirmPasswordValidator extends TextFieldValidator {
  final TextEditingController originalPass;

  ConfirmPasswordValidator(this.originalPass,
      {String errorText = 'Passwords do not match.'})
      : super(errorText);

  @override
  bool isValid(String? value) {
    return value == originalPass.text;
  }
}

class NameInput extends FormInput {
  NameInput(
      {Key? key,
      required TextEditingController controller,
      required String name})
      : super(
            key: key,
            keyboard: TextInputType.text,
            icon: const Icon(Icons.account_circle_rounded),
            hintText: name,
            validator: MultiValidator([
              RequiredValidator(errorText: name + " is required."),
              MaxLengthValidator(32, errorText: "Max characters reached.")
            ]),
            controller: controller);
}

class DateInput extends FormInput {
  DateInput(
      {Key? key,
        required TextEditingController controller})
      : super(
      key: key,
      keyboard: TextInputType.text,
      icon: const Icon(Icons.account_circle_rounded),
      hintText: "Birthdate (dd/mm/yyyy)",
      validator: MultiValidator([
        RequiredValidator(errorText: "Birthdate is required."),
        DateValidator("dd/mm/yyyy", errorText: "Invalid date.")
      ]),
      controller: controller);
}
