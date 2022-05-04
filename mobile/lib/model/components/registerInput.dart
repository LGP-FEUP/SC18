import 'package:flutter/material.dart';
import 'package:form_field_validator/form_field_validator.dart';

class RegisterInput extends StatefulWidget {
  final TextInputType keyboard;
  final Icon icon;
  final String hintText;
  final FieldValidator validator;
  final bool hidable;

  const RegisterInput({
    Key? key,
    required this.keyboard,
    required this.icon,
    required this.hintText,
    required this.validator,
    this.hidable = false,
  }) : super(key: key);

  @override
  State<StatefulWidget> createState() => _RegisterInputState();
}

class _RegisterInputState extends State<RegisterInput> {
  final _formKey = GlobalKey<FormState>();
  bool _hidden = true;



  @override
  Widget build(BuildContext context) {
    return TextFormField(
        keyboardType: widget.keyboard,
        obscureText: widget.hidable ? _hidden: false,
        decoration: InputDecoration(
            icon: widget.icon,
            hintText: widget.hintText,
            contentPadding: const EdgeInsets.all(20),
            suffixIcon: widget.hidable ? GestureDetector(
              onTap: () {
                setState(() {
                  _hidden = !_hidden;
                });
              },
              child: Icon(_hidden ? Icons.visibility : Icons.visibility_off),
            ) : null,
            border:
                OutlineInputBorder(borderRadius: BorderRadius.circular(50.0))),
        validator: widget.validator);
  }
}
