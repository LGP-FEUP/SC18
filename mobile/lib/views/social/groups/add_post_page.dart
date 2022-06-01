import 'package:erasmus_helper/layout.dart';
import 'package:erasmus_helper/models/post.dart';
import 'package:erasmus_helper/services/group_service.dart';
import 'package:erasmus_helper/views/app_topbar.dart';
import 'package:firebase_auth/firebase_auth.dart';
import 'package:flutter/material.dart';
import 'package:form_field_validator/form_field_validator.dart';


class AddPostPage extends StatefulWidget {
  final String groupId;

  const AddPostPage({Key? key, required this.groupId}) : super(key: key);

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
    return AppLayout(
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
      onPressed: _onSubmit,
      child: const Text("Submit"),
    ));
  }

  void _onSubmit() {
    if (_formKey.currentState!.validate()) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Submitting post')),
      );

      String user = FirebaseAuth.instance.currentUser!.uid;
      String text = postController.text.trim();
      int time = DateTime.now().millisecondsSinceEpoch * -1;

      PostModel post = PostModel(user, time, text);

      GroupService.addPost(widget.groupId, post)
          .then((value) => Navigator.pop(context, true));
    }
  }
}
