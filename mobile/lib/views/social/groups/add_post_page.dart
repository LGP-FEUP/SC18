import 'package:flutter/material.dart';
import 'package:form_field_validator/form_field_validator.dart';

import '../../app_topbar.dart';

class AddPostPage extends StatefulWidget {
  const AddPostPage({Key? key}) : super(key: key);

  @override
  State<StatefulWidget> createState() {
    return _AddPostPageState();
  }
}

class _AddPostPageState extends State<AddPostPage> {
  final _formKey = GlobalKey<FormState>();
  TextEditingController postController = TextEditingController();

  @override
  void dispose() {
    postController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return AppTopBar(
      activateBackButton: true,
      title: "Add Post",
      body: Form(
        key: _formKey,
        child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [_genInput(), _genButton()]),
      ),
    );
  }

  Widget _genInput() {
    const maxLines = 10;

    return Container(
        margin: const EdgeInsets.all(10),
        height: maxLines * 24.0,
        child: TextFormField(
            maxLines: maxLines,
            autocorrect: true,
            decoration: const InputDecoration(
              hintText: "Write something...",
              border: OutlineInputBorder(),
            ),
            validator: MultiValidator([
              RequiredValidator(errorText: "This is required."),
              MaxLengthValidator(300, errorText: "Max characters reached.")
            ]),
            controller: postController));
  }

  Widget _genButton() {
    return Center(
        child: ElevatedButton(
      onPressed: () {},
      child: Text("Submit"),
    ));
  }
}
