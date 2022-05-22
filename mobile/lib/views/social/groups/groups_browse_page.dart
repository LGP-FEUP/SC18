import 'package:erasmus_helper/services/user_service.dart';
import 'package:erasmus_helper/views/social/groups/components/group_carousel.dart';
import 'package:flutter/material.dart';

class GroupBrowserPage extends StatefulWidget {
  const GroupBrowserPage({Key? key}) : super(key: key);

  @override
  State<GroupBrowserPage> createState() => _GroupBrowserState();
}

class _GroupBrowserState extends State<GroupBrowserPage> {
  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
      future: UserService.getInterestUIDs(),
      builder: (context, response) {
        if (response.connectionState == ConnectionState.done) {
          if (response.data != null) {
            List<String> UIDs = response.data as List<String>;

            return ListView.builder(
                scrollDirection: Axis.vertical,
                itemCount: UIDs.length,
                itemBuilder: (BuildContext context, int index) {
                  return GroupCarousel(tagId: UIDs[index]);
                });
          }
        }
        return Container();
      },
    );
  }
}
