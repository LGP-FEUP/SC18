import 'package:flutter/material.dart';
import 'package:form_field_validator/form_field_validator.dart';

class FormInput extends StatefulWidget {
  final TextInputType keyboard;
  final Icon icon;
  final String hintText;
  final FieldValidator validator;
  final bool hidable;
  TextEditingController controller;

  FormInput({
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

class ConfirmPasswordValidator extends TextFieldValidator {
  final String originalPass;
  ConfirmPasswordValidator(this.originalPass, {String errorText = 'Passwords do not match.'}) : super(errorText);

  @override
  bool isValid(String? value) {
    print("C: " + value!);
    print("P: " + originalPass);
    return value == originalPass;
  }
}
