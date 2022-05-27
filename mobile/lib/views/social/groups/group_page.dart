import 'package:erasmus_helper/views/social/components/forum_post.dart';
import 'package:flutter/material.dart';
import 'package:flutterfire_ui/database.dart';

import '../../../models/post.dart';
import '../../../services/group_service.dart';
import '../../app_topbar.dart';

class GroupPage extends StatefulWidget {
  final String groupId;
  const GroupPage({Key? key, required this.groupId}) : super(key: key);

  @override
  State<StatefulWidget> createState() {
    return _GroupPageState();
  }
}

class _GroupPageState extends State<GroupPage> {
  List<PostModel> posts = [];

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
        future: GroupService.getGroupPosts("karting"),
        builder: (context, response) {
          if (response.connectionState == ConnectionState.done) {
            if (response.data != null) {
              posts = response.data as List<PostModel>;
              return AppTopBar(
                  activateBackButton: true,
                  title: "Forum",
                  body: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [_genCover(), _genPostsList()]));
            }
            return _genCover();
          }
          return _genCover();
        });
  }

  Widget _genCover() {
    return Stack(children: <Widget>[
      Container(
        decoration: const BoxDecoration(
            image: DecorationImage(
                image: NetworkImage(
                    "https://static.vecteezy.com/system/resources/previews/000/671/117/original/triangle-polygon-background-vector.jpg"),
                fit: BoxFit.cover)),
        height: 170.0,
      ),
      _genTitle(),
    ]);
  }

  Widget _genTitle() {
    final gradient = BoxDecoration(
      gradient: LinearGradient(
        begin: Alignment.topCenter,
        end: Alignment.bottomCenter,
        colors: <Color>[
          Colors.black.withAlpha(0),
          Colors.black26,
          Colors.black87
        ],
      ),
    );

    return Container(
      height: 170,
      alignment: Alignment.bottomLeft,
      decoration: gradient,
      child: const Padding(
        padding: EdgeInsets.all(5),
        child: Text(
          'Karting',
          style: TextStyle(color: Colors.white, fontSize: 20.0),
        ),
      ),
    );
  }

  Widget _genPostsList() {
    return FirebaseDatabaseListView(
      query: GroupService.queryGroupPosts("karting"),
      scrollDirection: Axis.vertical,
      shrinkWrap: true,
      itemBuilder: (context, snapshot) {
        Map<String, dynamic> value = (snapshot.value as Map<dynamic, dynamic>)
            .map((key, value) => MapEntry(key.toString(), value));
        PostModel post = PostModel.fromJson(snapshot.key.toString(), value);
        return ForumPost(post: post);
      },
    );
  }
}

// ForumPost(post: posts[index])
